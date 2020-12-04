## Модуль Laminas - Telegram Бот анти спам регистраций

#### Реализация в структуре приложения Laminas здесь [GitHub](https://github.com/northmule/telegram-antisapm-registrations-bot)

### Установка
```
composer require northmule/telegram-bot-anti-registration
```

### Настроки
1. Переназначить массив настроек модуля в глобальном приложении
```
 return [
    'telegramBot' => [
        'apiKey' => '', //  Токен можно узнать/создать через @BotFather
        'botUsername' => '',
        'bootHookUrl' => 'https://exemple.ru', //Внешний адрес куда должны поступать запросы от Телеграм
        'logger' => [
            'telegramLog' => '', // Путь до файла логов запросов Телеграм
            'fileLog' => '', // Путь до файла логов ошибок
        ],
        'disableRouteSet' => 0, // Отключить режим настройки
    ]
];    

```
### Стандартные маршруты
1. https://exemple.ru/telegram-bot/set-hook - Режим настройки (должен быть включен)
2. https://exemple.ru/telegram-bot/bot-echo - Приёмник запросов с сервиса Telegram
