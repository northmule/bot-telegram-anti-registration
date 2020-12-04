## Модуль Laminas - Telegram Бот анти спам регистраций

#### Реализация в структуре приложения Laminas здесь [GitHub](https://github.com/northmule/telegram-antisapm-registrations-bot)

### Описание
При вступлнеии пользователя в группу, бот блокирует все действия пользователя, до тех пор пока
не получит от пользователя ответ на вопрос.

### Установка
```
composer require northmule/telegram-bot-anti-registration
```

### Настройка
1. Переназначить массив настроек модуля в глобальном приложении
```
 return [
    'telegramBot' => [
        'apiKey' => 'ТУТ_АБРАКАДАБРА_КЛЮЧ', //  Токен можно узнать/создать через @BotFather
        'botUsername' => '',
        'bootHookUrl' => 'https://exemple.ru', // Домен на адрес которого будут приходить сообщения от Telegram
        'logger' => [
            'telegramLog' => '', // Путь до файла логов запросов Телеграм. Файл должен существовать
            'fileLog' => '', // Путь до файла логов ошибок. Файл должен существовать
        ],
        'disableRouteSet' => 0, // Отключить режим настройки
    ]
];    

```
### Пояснение опций
1. apiKey - Токен Телеграм, который вы получаете самостоятельно после создания бота
2. botUsername - Имя бота
3. bootHookUrl - Домен с https:// без слэша в конце. Сюда будут приходить Json сообщения от Telegram
4. logger - Абсолютные пути до файлов, для записи логов
5. disableRouteSet - после однократного использования, можно указать 1


### Стандартные маршруты
1. https://exemple.ru/telegram-bot/set-hook - Режим настройки
2. https://exemple.ru/telegram-bot/bot-echo - Приёмник запросов с сервиса Telegram

### Прочее
 - Готовое приложение с всей структурой для запуска на своём хостинге - [Laminas Skeleton](https://github.com/northmule/telegram-antisapm-registrations-bot)

## Дополнительная информация
Ссылки на документацию сторонних источников
- [Laminas](https://getlaminas.org/)
- [PHP Telegram CORE](https://github.com/php-telegram-bot/core)
- [TelegramAPI](https://core.telegram.org/)
