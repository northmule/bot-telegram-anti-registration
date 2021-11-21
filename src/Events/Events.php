<?php

declare(strict_types=1);

namespace Northmule\Telegram\Events;

use Exception;
use Laminas\EventManager\Event;
use Laminas\EventManager\EventManager;
use Laminas\Log\Logger;
use Laminas\ServiceManager\ServiceManager;
use Longman\TelegramBot\Entities\CallbackQuery;
use Longman\TelegramBot\Entities\Message;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Entities\User;
use Longman\TelegramBot\Entities\User as UserEntities;
use Longman\TelegramBot\Request;
use Northmule\Telegram\Map\Events as EventsMap;
use Northmule\Telegram\Map\QuestionKeyboard;
use Northmule\Telegram\Options\ModuleOptions;
use Northmule\Telegram\Service\KeyboardQuestion as KeyboardQuestionService;
use Northmule\Telegram\Service\TelegramRestrict;

use function count;

class Events
{
    /** @var string  */
    const MASK_USER_NAME = '#user_name#';

    /**
     * @var ServiceManager
     */
    protected ServiceManager $serviceManager;
    /**
     * @var Logger
     */
    protected Logger $logger;
    
    protected ModuleOptions $options;
    
    /**
     * Events constructor.
     *
     * @param ServiceManager $serviceManager
     * @param Logger         $logger
     * @param ModuleOptions  $options
     */
    public function __construct(
        ServiceManager $serviceManager,
        Logger $logger,
        ModuleOptions $options
    ) {
        $this->serviceManager = $serviceManager;
        $this->logger = $logger;
        $this->options = $options;
    }


    /**
     * Проверка ответа пользователя на вопрос от Бота
     *
     * @param Event $event
     *
     * @return ServerResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function checkUsersResponse(Event $event): ServerResponse
    {
        $message = $event->getParam('message', null);
        $user = $event->getParam('user', null);
        $callback = $event->getParam('callback', null);

        try {
            if (
                $this->isValidEvent(
                    $event,
                    [
                        'message'  => Message::class,
                        'user'     => User::class,
                        'callback' => CallbackQuery::class,
                    ]
                ) === false
            ) {
                throw new Exception('The data is not valid: message|user|callback');
            }

            $approved = false;

            if ($callback->getData() === QuestionKeyboard::CALLBACK_ANSWER_HUMAN . $user->getId()) {
                $approved = true;
            }

            if ($approved) {
                $eventManager = $this->serviceManager->get(EventManager::class);
                /** @var  TelegramRestrict $restrictionService */
                $restrictionService = $this->serviceManager->get(
                    TelegramRestrict::class
                );
                $eventManager->trigger(
                    EventsMap::THE_NEW_USER_ANSWERED_CORRECTLY,
                    null,
                    ['user' => $user, 'message' => $message]
                );
                // Снимаем ограничения
                $restrictionService->unsetRestrict(
                    $message->getChat()->getId(),
                    $user->getId()
                );

                // Удаление сообщения
                Request::deleteMessage(
                    [
                        'chat_id'    => $message->getChat()->getId(),
                        'message_id' => $message->getMessageId(),
                    ]
                );
    
                if ($this->options->getShowGreetingAfterResponse() && !empty($this->options->getTextOfGreeting())) {
                    // Отправляем сообщение
                    return Request::sendMessage([
                        'chat_id'              => $message->getChat()->getId(),
                        'text'                 => $this->options->getTextOfGreeting(),
                        'disable_notification' => true,
                    ]);
                }
            }
        } catch (\Throwable $e) {
            $this->logger->err($e->getMessage(), $e->getTrace());
        }

        return Request::emptyResponse();
    }

    /**
     * Обработка действия пользователя на вступление в группу
     *
     * @param Event $event
     *
     * @return ServerResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function processRequestToJoinGroup(Event $event): ServerResponse
    {
        /** @var Message $message */
        $message = $event->getParam('message', null);
        $members = $event->getParam('members', []);

        if ($this->isValidEvent($event, ['message' => Message::class]) === false) {
            return Request::emptyResponse();
        }
        /** @var KeyboardQuestionService $keybord */
        $keybord = $this->serviceManager->get(KeyboardQuestionService::class);
        $keybord->setCurentUserId((string) $message->getFrom()->getId());
        /** @var  TelegramRestrict $restrictionService */
        $restrictionService = $this->serviceManager->get(
            TelegramRestrict::class
        );
        $question = $keybord->getQuestion();
        try {
            // Ограничить нового пользователя в правах, до ответа на вопрос
            $restrictionService->setRestrict(
                $message->getChat()->getId(),
                $message->getFrom()->getId()
            );
            $member_names = [];
            $memberIsBot = false;
            /** @var UserEntities $member */
            foreach ($members as $member) {
                $member_names[] = $member->tryMention(true);
                if ($memberIsBot === false) {
                    $memberIsBot = $member->getIsBot();
                }
            }
            if ($message->getType() === 'new_chat_members') {
                // Удаление сообщения о вступившем
                Request::deleteMessage(
                    [
                        'chat_id'    => $message->getChat()->getId(),
                        'message_id' => $message->getMessageId(),
                    ]
                );
            }
            // Ботов не спрашиваем, просто ограничиваем в правах
            if ($memberIsBot === true) {
                Request::emptyResponse();
            }
            if ($this->options->getAskQuestions() === true) {
                $sendText = str_replace(self::MASK_USER_NAME, implode(', ', $member_names), $this->options->getTextQuestion());
                return Request::sendMessage(
                    array_merge([
                        'chat_id'              => $message->getChat()->getId(),
                        'text'                 => $sendText,
                        'disable_notification' => true,
                    ], $question)
                );
            } else { // Снимаем ограничение (предполагаем что боты отсекаются по умолчанию)
                // Снимаем ограничения
                $restrictionService->unsetRestrict(
                    $message->getChat()->getId(),
                    $message->getFrom()->getId(),
                );
            }

        } catch (\Exception $e) {
            $this->logger->err($e->getMessage(), $e->getTrace());
        }
        return Request::emptyResponse();
    }

    /**
     * not use
     * @param Event $event
     *
     * @return ServerResponse
     */
    public function checkingUserForHumanity(Event $event): ServerResponse
    {
        try {
            /** @var Message $message */
            $message = $event->getParam('message');
            if ($this->isValidEvent($event, ['message' => Message::class]) === false) {
                throw new Exception('The data is not valid: message');
            }
            foreach ($message->getNewChatMembers() as $member) {
                $member_names[] = $member->tryMention(true);
            }
        } catch (\Throwable $e) {
            $this->logger->err($e->getMessage(), $e->getTrace());
        }
        return Request::emptyResponse();
    }

    /**
     * @param Event    $event
     * @param string[] $checkParam
     *
     * @return bool
     */
    protected function isValidEvent(Event $event, array $checkParam): bool
    {
        $countItem = count($checkParam);
        $verifiedItem = 0;

        foreach ($checkParam as $itemParam => $itemClassName) {
            $valueParam = $event->getParam($itemParam, null);
            if ($valueParam instanceof $itemClassName === true) {
                $verifiedItem++;
            }
        }

        return ($countItem === $verifiedItem);
    }
}
