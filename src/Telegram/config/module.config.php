<?php

use Interop\Container\ContainerInterface;

return [
    'service_manager' =>[
        'factories' => [
            Coderun\Telegram\Options\ModuleOptions::class => Coderun\Telegram\Options\Factory\ModuleOptions::class,
            Coderun\Telegram\Commands\NewchatmembersCommand::class => Coderun\Telegram\Commands\Factory\NewchatMembers::class,
            Coderun\Telegram\Events\Events::class => Coderun\Telegram\Events\Factory\Events::class,
            Coderun\Telegram\Service\TelegramApi::class => Coderun\Telegram\Service\Factory\TelegramApi::class,
        ],
        'invokables' => [
            Coderun\Telegram\Service\KeybordQuestion::class => Coderun\Telegram\Service\KeybordQuestion::class,
            Coderun\Telegram\Service\TelegramRestrict::class => Coderun\Telegram\Service\TelegramRestrict::class,
            Laminas\EventManager\EventManager::class => Laminas\EventManager\EventManager::class

        ],
        'aliases' => []
    ],
    'controllers' => [
        'factories' =>
            [
                Coderun\Telegram\Controller\Bot::class => Coderun\Telegram\Controller\Factory\Bot::class,
                Coderun\Telegram\Controller\Service::class =>  Coderun\Telegram\Controller\Factory\Service::class,
            ],
    ],

];