<?php

declare(strict_types=1);

namespace Northmule\Telegram\Service;

use Longman\TelegramBot\Entities\InlineKeyboard;
use Northmule\Telegram\Map\QuestionKeyboard as QuestionKeyboardMap;

/**
 * @see     https://github.com/php-telegram-bot/example-bot/blob/master/Commands/Keyboard/KeyboardCommand.php
 * @see     https://github.com/php-telegram-bot/example-bot/blob/master/Commands/Keyboard/InlinekeyboardCommand.php
 * Class KeyboardQuestion
 *
 * @package Northmule\Telegram\Service
 */
class KeyboardQuestion
{
    
    protected $curentUserId = '';
    
    /**
     * Вернёт клавиатуру с вопросом для пользователя
     *
     * @return array [reply_markup => InlineKeyboard]
     */
    public function getQuestion(): array
    {
        
        $keyboard = new InlineKeyboard([
            ['text'          => 'Я бот!',
             'callback_data' => QuestionKeyboardMap::CALLBACK_ANSWER_BOT
                 . $this->curentUserId],
            ['text'          => 'Я человек!',
             'callback_data' => QuestionKeyboardMap::CALLBACK_ANSWER_HUMAN
                 . $this->curentUserId],
        ]);
        
        return ['reply_markup' => $keyboard];
        
    }
    
    /**
     * Set curentUserId
     *
     * @param string $curentUserId
     *
     * @return KeyboardQuestion
     */
    public function setCurentUserId(string $curentUserId): KeyboardQuestion
    {
        $this->curentUserId = $curentUserId;
        return $this;
    }
    
}