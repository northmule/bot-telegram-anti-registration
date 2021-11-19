<?php

declare(strict_types=1);

namespace Northmule\Telegram\Commands;

use Exception;
use Laminas\EventManager\EventManager;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;
use Northmule\Telegram\Map\Events;
use Northmule\Telegram\Service\TelegramApi;

class CallbackqueryCommand extends SystemCommand
{

    const NAME_COMMAND = 'callbackquery';

    /**
     * @var string
     */
    protected $name = self::NAME_COMMAND;
    /**
     * @var string
     */
    protected $description = 'Сообщение с кнопки приветствия';
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
        /** @var TelegramApi $this- >telegram */
        /** @var EventManager $eventManager */
        $eventManager = $this->telegram->getServiceManager()->get(
            EventManager::class
        );
        $callback = $this->getCallbackQuery();
        $message = $callback->getMessage();
        $user = $callback->getFrom();

        try {
            $eventManager->trigger(
                Events::NEW_USER_CREATED_AN_ANSWER_VERIFICATION_QUESTION,
                null,
                [
                    'message'  => $message,
                    'user'     => $user,
                    'callback' => $callback,
                ]
            );
        } catch (\Throwable $e) {
            $this->telegram->getLogger()->err($e->getMessage(), $e->getTrace());
        }


        return Request::emptyResponse();
    }
}
