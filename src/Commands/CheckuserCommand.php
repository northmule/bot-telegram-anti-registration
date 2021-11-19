<?php

declare(strict_types=1);

namespace Northmule\Telegram\Commands;

use Laminas\EventManager\EventManager;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use Northmule\Telegram\Map\Events;

/**
 * Class CheckUserCommand
 *
 * @package Northmule\Telegram\Commands
 */
class CheckuserCommand extends SystemCommand
{
    /** @var string  */
    const NAME_COMMAND = 'checkuser';

    /**
     * @var string
     */
    protected $name = self::NAME_COMMAND;
    /**
     * @var string
     */
    protected $description = 'Check user';
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
        /** @var EventManager $eventManager */
        $eventManager = $this->telegram->getServiceManager()->get(
            EventManager::class
        );
        $message = $this->getMessage();

        $eventManager->trigger(
            Events::NEW_CHAT_MESSAGE_FROM_A_USER,
            null,
            ['message' => $message]
        );

        return Request::emptyResponse();
    }
}
