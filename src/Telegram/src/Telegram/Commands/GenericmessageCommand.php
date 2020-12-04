<?php

declare(strict_types=1);

namespace Coderun\Telegram\Commands;

use Coderun\Telegram\Service\TelegramApi;
use Laminas\EventManager\EventManager;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

/**
 * Общая команда сообщения
 *
 * Выполняется при отправке любого типа сообщения.
 *
 * В этом связанном с группой контексте мы можем обрабатывать новых и оставленных членов группы.
 */
class GenericmessageCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'genericmessage';
    
    /**
     * @var string
     */
    protected $description = 'Handle generic message';
    
    /**
     * @var string
     */
    protected $version = '1.0.0';
    
    /**
     * Main command execution
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {
        /** @var TelegramApi $this->telegram */
        /** @var \Laminas\EventManager\EventManager $eventManager */
        $eventManager = $this->telegram->getServiceManager()->get(EventManager::class);
        
        /** @var \Longman\TelegramBot\Entities\Message $message */
        $message = $this->getMessage();
        
        
        // Новый участник группы
        if ($message->getNewChatMembers()) {
            return $this->getTelegram()->executeCommand('newchatmembers');
        }
        
        // Участник покинул группу
        if ($message->getLeftChatMember()) {
            return $this->getTelegram()->executeCommand('leftchatmember');
        }
        
        // The chat photo was changed
        if ($new_chat_photo = $message->getNewChatPhoto()) {
            // Whatever...
        }
        
        // The chat title was changed
        if ($new_chat_title = $message->getNewChatTitle()) {
            // Whatever...
        }
        
        // A message has been pinned
        if ($pinned_message = $message->getPinnedMessage()) {
            // Whatever...
        }
        
        return Request::emptyResponse();
    }
}