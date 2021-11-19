<?php

declare(strict_types=1);

namespace Northmule\Telegram\Map;

/**
 * Имена событий
 *
 * Class Events
 *
 * @package Northmule\Telegram\Map
 */
class Events
{

    /**
     * Пользователь вступил в группу
     *
     * @var string
     */
    public const NEW_USER_SENT_REQUEST_TO_JOIN_GROUP = 'NEW_USER_SENT_REQUEST_TO_JOIN_GROUP';
    /**
     * Пользователь дал ответ на вопрос
     *
     * @var string
     */
    public const NEW_USER_CREATED_AN_ANSWER_VERIFICATION_QUESTION = 'NEW_USER_CREATED_AN_ANSWER_VERIFICATION_QUESTION';
    /**
     * Пользователь дал верный ответ
     *
     * @var string
     */
    public const THE_NEW_USER_ANSWERED_CORRECTLY = 'THE_NEW_USER_ANSWERED_CORRECTLY';
    /**
     * Новое сообщение в чате
     *
     * @var string
     */
    public const NEW_CHAT_MESSAGE_FROM_A_USER = 'NEW_CHAT_MESSAGE_FROM_A_USER';
}
