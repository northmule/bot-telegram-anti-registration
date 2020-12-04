<?php

declare(strict_types=1);

namespace Coderun\Telegram\Service;

use Longman\TelegramBot\Entities\InlineKeyboard;
use Coderun\Telegram\Map\QuestionKeyboard as QuestionKeyboardMap;

/**
 * @see https://github.com/php-telegram-bot/example-bot/blob/master/Commands/Keyboard/KeyboardCommand.php
 * @see https://github.com/php-telegram-bot/example-bot/blob/master/Commands/Keyboard/InlinekeyboardCommand.php
 * Class KeybordQuestion
 *
 * @package Coderun\Telegram\Service
 */
class KeybordQuestion
{
    
    protected $curentUserId = '';
    
    /**
     * Вернёт клавиатуру с вопросом для пользователя
     * @return array [reply_markup => InlineKeyboard]
     */
    public function getQuestion()
    {
        
        $keyboard = new InlineKeyboard([
            ['text' => 'Я бот!', 'callback_data' => QuestionKeyboardMap::CALLBACK_ANSWER_BOT.$this->curentUserId],
            ['text' => 'Я человек!', 'callback_data' => QuestionKeyboardMap::CALLBACK_ANSWER_HUMAN.$this->curentUserId],
        ]);
        
        return ['reply_markup' => $keyboard];
        
    }
    
    /**
     * Set curentUserId
     *
     * @param string $curentUserId
     *
     * @return KeybordQuestion
     */
    public function setCurentUserId(string $curentUserId): KeybordQuestion
    {
        $this->curentUserId = $curentUserId;
        return $this;
    }
    
}