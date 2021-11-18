<?php

use Interop\Container\ContainerInterface;

return [
    'service_manager' =>[
        'factories' => [
            Northmule\Telegram\Options\ModuleOptions::class => Northmule\Telegram\Options\Factory\ModuleOptions::class,
            Northmule\Telegram\Commands\NewchatmembersCommand::class => Northmule\Telegram\Commands\Factory\NewchatMembers::class,
            Northmule\Telegram\Events\Events::class => Northmule\Telegram\Events\Factory\Events::class,
            Northmule\Telegram\Service\TelegramApi::class => Northmule\Telegram\Service\Factory\TelegramApi::class,
        ],
        'invokables' => [
            Northmule\Telegram\Service\KeyboardQuestion::class => Northmule\Telegram\Service\KeyboardQuestion::class,
            Northmule\Telegram\Service\TelegramRestrict::class => Northmule\Telegram\Service\TelegramRestrict::class,
            Laminas\EventManager\EventManager::class => Laminas\EventManager\EventManager::class

        ],
        'aliases' => []
    ],
    'controllers' => [
        'factories' =>
            [
                Northmule\Telegram\Controller\Bot::class => Northmule\Telegram\Controller\Factory\Bot::class,
                Northmule\Telegram\Controller\Service::class =>  Northmule\Telegram\Controller\Factory\Service::class,
            ],
    ],

];