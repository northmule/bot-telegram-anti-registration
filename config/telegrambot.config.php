<?php

/**
 * Команды
 * @see https://github.com/php-telegram-bot/example-bot/tree/master/Commands
 *
 */

return [
    'telegramBot' => [
        'apiKey'          => '', //  Токен можно узнать/создать через @BotFather
        'botUsername'     => '',
        'bootHookUrl'     => '', //Внешний адрес куда должны поступать запросы от Телеграм
        'commandsPath'    => [__DIR__ . '/../src/Commands'], // Папки к командам
        'logger'          => [
            'telegramLog' => '', // Путь до файла логов запросов Телеграм
            'fileLog'     => '', // Путь до файла логов ошибок
        ],
        'disableRouteSet' => 0,
    ],
];
