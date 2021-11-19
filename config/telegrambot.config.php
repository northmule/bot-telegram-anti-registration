<?php

/**
 * Команды
 * @see https://github.com/php-telegram-bot/example-bot/tree/master/Commands
 *
 */
// По умолчанию при любых настройках, боты всегда отсекаются при вступлении в группу
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
        'showGreetingAfterResponse' => false, // Показывать приветствие после вступления в группу
        'textOfGreeting' => 'Добро пожаловать', // Текст приветствия после успешного ответа
        'textQuestion' => 'Привет #user_name#! Скажи кто ты?', // Текст вопроса, можно указать #user_name# - будет заменён на имя вступившего
        'askQuestions' => true, // Задавать вопросов? Если false, проверки вопросом не будет
    ],
];
