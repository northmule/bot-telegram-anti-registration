<?php

declare(strict_types=1);

namespace Northmule\Telegram\Commands;

use Laminas\EventManager\EventManager;
use Laminas\ServiceManager\ServiceManager;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\Message;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use Northmule\Telegram\Map\Events;
use Northmule\Telegram\Service\TelegramApi;


/**
 * Команда вызывается когда в группу вступает новый участник
 * Class NewchatmembersCommand
 *
 * @package Northmule\Telegram\Commands
 */
class NewchatmembersCommand extends SystemCommand
{
    /** @var string  */
    const NAME_COMMAND = 'newchatmembers';
    
    /**
     * @var string
     */
    protected $name = self::NAME_COMMAND;
    
    /**
     * @var string
     */
    protected $description = 'New Chat Members';
    
    /**
     * @var string
     */
    protected $version = '1.3.0';
    
    /**
     * Main command execution
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {
        /** @var EventManager $eventManager */
        $eventManager = $this->telegram->getServiceManager()->get(
            EventManager::class
        );
        $message = $this->getMessage();
        /** @var array $members */
        $members = $message->getNewChatMembers();
        
        $eventManager->trigger(
            Events::NEW_USER_SENT_REQUEST_TO_JOIN_GROUP,
            null,
            ['message' => $message, 'members' => $members]
        );
        
        return Request::emptyResponse();
    }
    
}