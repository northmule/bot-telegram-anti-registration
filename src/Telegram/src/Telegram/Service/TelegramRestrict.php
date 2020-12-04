<?php

declare(strict_types=1);

namespace Coderun\Telegram\Service;

use Longman\TelegramBot\Request;

/**
 * Установка и снятие ограничений на пользователя
 * Установка/снятие разрешений на пользователя не затрагивает общих разрешений на группу.
 * Общие разрешения на группу остаются приоритетными
 * Class TelegramRestrict
 *
 * @see https://core.telegram.org/bots/api#chatpermissions
 * @see https://core.telegram.org/bots/api#restrictchatmember
 *
 * @package Coderun\Telegram\Service
 */
class TelegramRestrict
{
    
    /**
     * Запретить пользователю в чате любые действия
     * @param int $chatId
     * @param int $userId
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     */
    public function setRestrict(int $chatId, int $userId)
    {
       return Request::restrictChatMember([
            'chat_id' => $chatId,
            'user_id' => $userId,
            'permissions' => [
                'can_send_messages' => false, // Отправка сообщений
                'can_send_media_messages' => false,
                'can_send_polls' => false,
                'can_send_other_messages' => false,
                'can_add_web_page_previews' => false,
                'can_change_info' => false,
                'can_invite_users' => false,
                'can_pin_messages' => false,
            ],
        ]);
    }
    
    /**
     * Установка всех разрешений для пользователя в true
     *
     * @param int $chatId
     * @param int $userId
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     */
    public function unsetRestrict(int $chatId, int $userId)
    {
        return Request::restrictChatMember([
            'chat_id' => $chatId,
            'user_id' => $userId,
            'permissions' => [
                'can_send_messages' => true,
                'can_send_media_messages' => true,
                'can_send_polls' => true,
                'can_send_other_messages' => true,
                'can_add_web_page_previews' => true,
                'can_change_info' => true,
                'can_invite_users' => true,
                'can_pin_messages' => true,
            ],
        ]);
    }
}