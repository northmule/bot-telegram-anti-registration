<?php

declare(strict_types=1);

namespace Northmule\Telegram\Events;

use Doctrine\ORM\EntityManager;
use Laminas\EventManager\Event;
use Laminas\EventManager\EventManager;
use Laminas\Log\Logger;
use Laminas\ServiceManager\ServiceManager;
use Longman\TelegramBot\Entities\CallbackQuery;
use Longman\TelegramBot\Entities\Message;
use Longman\TelegramBot\Entities\User;
use Longman\TelegramBot\Entities\User as UserEntities;
use Longman\TelegramBot\Request;
use Northmule\Telegram\Entity\UsersChat;
use Northmule\Telegram\Map\Events as EventsMap;
use Northmule\Telegram\Map\QuestionKeyboard;
use Northmule\Telegram\Service\KeybordQuestion;
use Northmule\Telegram\Service\TelegramRestrict;


class Events
{
    
    /**
     * @var ServiceManager
     */
    protected $serviceManager;
    
    /**
     * @var EntityManager
     */
    protected $entityManager;
    
    /**
     * @var Logger
     */
    protected $logger;
    
    /**
     * Events constructor.
     *
     * @param ServiceManager $serviceManager
     * @param EntityManager  $entityManager
     */
    public function __construct(
        EntityManager $entityManager,
        ServiceManager $serviceManager,
        Logger $logger
    ) {
        $this->serviceManager = $serviceManager;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }
    
    
    /**
     * Проверка ответа пользователя на вопрос от Бота
     */
    public function checkUsersResponse(Event $event)
    {
        $message = $event->getParam('message',null);
        $user = $event->getParam('user',null);
        $callback = $event->getParam('callback', null);
        
        if (!($message instanceof Message)) {
            return;
        }
        
        if (!($user instanceof User)) {
            return;
        }
        if (!($callback instanceof CallbackQuery)) {
            return;
        }
        
        $approved = false;
        
        if ($callback->getData() === QuestionKeyboard::CALLBACK_ANSWER_HUMAN.$user->getId()) {
            $approved = true;
        }
        
        /** @var  TelegramRestrict $restrictionService */
        $restrictionService = $this->serviceManager->get(TelegramRestrict::class);

        try {
            if ($approved) {
                $eventManager = $this->serviceManager->get(EventManager::class);
                $eventManager->trigger(
                    EventsMap::THE_NEW_USER_ANSWERED_CORRECTLY,
                    null,
                    ['user' => $user,'message' => $message]
                );
                // Снимаем ограничения
                $restrictionService->unsetRestrict($message->getChat()->getId(),$user->getId());
                
                // Удаление сообщения
                Request::deleteMessage(
                    [
                        'chat_id' => $message->getChat()->getId(),
                        'message_id' => $message->getMessageId(),
                    ]
                );
                
                // Отправляем сообщение
                return  Request::sendMessage([
                    'chat_id' => $message->getChat()->getId(),
                    'text'    => "Добро пожаловать!",
                    'disable_notification' => true,
                ]);
                
            }
        } catch (\Exception $e) {
            $this->logger->err($e->getMessage(),$e->getTrace());
            return;
        }

    }
    
    /**
     * Обработка действия пользователя на вступление в группу
     * @param Event $event
     */
    public function processRequestToJoinGroup(Event $event)
    {
        $message = $event->getParam('message',null);
        $members = $event->getParam('members',[]);
        if (!($message instanceof Message)) {
            return;
        }
        
        /** @var KeybordQuestion $keybord */
        $keybord = $this->serviceManager->get(KeybordQuestion::class);
        $keybord->setCurentUserId((string)$message->getFrom()->getId());
        /** @var  TelegramRestrict $restrictionService */
        $restrictionService = $this->serviceManager->get(TelegramRestrict::class);
        $question = $keybord->getQuestion();
        try {
            // Ограничить нового пользователя в правах, до ответа на вопрос
            $restrictionService->setRestrict($message->getChat()->getId(),$message->getFrom()->getId());
            
            if ($message->botAddedInChat()) { // только бот
                return  Request::sendMessage([
                    'chat_id' => $message->getChat()->getId(),
                    'text'    => "Привет бот!",
                    'disable_notification' => true,
                ]);
            }
            
            $member_names = [];
            /** @var UserEntities $member */
            foreach ($members as $member) {
                $member_names[] = $member->tryMention();
            }
            
            return  Request::sendMessage(
                array_merge([
                    'chat_id' => $message->getChat()->getId(),
                    'text'    => 'Привет! ' . implode(', ', $member_names) . '! Скажи, кто ты?',
                    'disable_notification' => true,
                ],$question)
            );
        } catch (\Exception $e) {
            $this->logger->err($e->getMessage(),$e->getTrace());
            return;
        }
        
        
    }
    
    public function addUserToTable(Event $event):void
    {
        $message = $event->getParam('message',null);
        $members = $event->getParam('members',[]);
        
        if (!($message instanceof Message)) {
            return;
        }
        /** @var UserEntities $user */
        $user = reset($members);
        if (!($user instanceof UserEntities)) {
            return;
        }
        
        try {
            $userChat = new UsersChat();
            $userChat->setApproved(false);
            $userChat->setChatId($message->getChat()->getId());
            $userChat->setChatName($message->getChat()->getUsername()??'');
            $userChat->setLanguageCode($user->getLanguageCode()??'');
            $userChat->setUserId($user->getId());
            $userChat->setUserName($user->getUsername()??'');
            $this->entityManager->persist($userChat);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            $this->logger->err($e->getMessage(),$e->getTrace());
            return;
        }

    }
    
    public function updateUserToTable(Event $event):void
    {

        $message = $event->getParam('message',null);
        $user = $event->getParam('user',null);
        
        if (!($message instanceof Message)) {
            $this->logger->info(sprintf('Процесс обработки события %s, ожидается объект %s',EventsMap::THE_NEW_USER_ANSWERED_CORRECTLY,Message::class));
            return;
        }
        
        if (!($user instanceof UserEntities)) {
            $this->logger->info(sprintf('Процесс обработки события %s, ожидается объект %s',EventsMap::THE_NEW_USER_ANSWERED_CORRECTLY,UserEntities::class));
    
            return;
        }
        try {
            $repository = $this->entityManager->getRepository(UsersChat::class);
            $userChat = $repository->findOneBy(['userId' => $user->getId(),'chatId' => $message->getChat()->getId()],['id'=> 'DESC']);
            if (!($userChat instanceof UsersChat)) {
                return;
            }
            $userChat->setApproved(true);
            $this->entityManager->persist($userChat);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            $this->logger->err($e->getMessage(),$e->getTrace());
            return;
        }
        
    }
}