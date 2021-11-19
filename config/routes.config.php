<?php

use Laminas\Router\Http\Literal;

return [
    'router' => [
        'routes' => [
            // слушает команды сервиса Telegram
            'telegramBotEcho' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/telegram-bot/bot-echo',
                    'defaults' => [
                        'controller' => Northmule\Telegram\Controller\Bot::class,
                        'action'     => 'echo',
                    ],
                ],
            ],
            // Установка обработчика. Выполняется 1-н раз для настройки
            'telegramSetHook' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/telegram-bot/set-hook',
                    'defaults' => [
                        'controller' => Northmule\Telegram\Controller\Service::class,
                        'action'     => 'setHook',
                    ],
                ],
            ],
        ],
    ],



];
