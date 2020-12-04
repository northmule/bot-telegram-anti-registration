<?php

namespace Coderun\Telegram\Entity;

use Coderun\Telegram\Entity\DefaultFields;
use Doctrine\ORM\Mapping as Doctrine;


/**
 * @Doctrine\Entity (repositoryClass="\Coderun\Telegram\Repository\UsersChat")
 * @Doctrine\HasLifecycleCallbacks
 * @Doctrine\Table (name="coderun_bot_telegram_users_chat",
 *     options={"comment":"Пользователи чата"},
 *     indexes={@Doctrine\Index(name="user_in_chat_idx",columns={"userId","chatId"})})
 * @Doctrine\InheritanceType("SINGLE_TABLE")
 */
class UsersChat
{
    
    use DefaultFields;
    /**
     * @var int
     *
     * @Doctrine\Column(name="userId", type="bigint", nullable=true,options={"comment":"ИД пользователя Телеграм"})
     */
    protected $userId;
    
    /**
     * @var string
     * @Doctrine\Column(name="userName",type="string",length=250,nullable=true,options={"comment":"логин пользователя"})
     */
    protected $userName;
    
    /**
     * @var bool
     * @Doctrine\Column(name="approved",type="boolean",options={"comment":"Можно писать в чат или нет"})
     */
    protected $approved;
    
    /**
     * @var string
     * @Doctrine\Column(name="languageCode",type="string",length=20,nullable=true,options={"comment":"Код языка"})
     */
    protected $languageCode;
    
    /**
     * @var integer
     * @Doctrine\Column(name="chatId",type="bigint",nullable=false,options={"comment":"ИД чата"})
     */
    protected $chatId;
    /**
     * @var string
     * @Doctrine\Column(name="chatName",type="string",length=250,nullable=true,options={"comment":"Имя чата"})
     */
    protected $chatName;
    

    public function __construct()
    {
        $this->approved = false;
    }
    
    /**
     * Get userId
     *
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }
    
    /**
     * Set userId
     *
     * @param int $userId
     *
     * @return UsersChat
     */
    public function setUserId(int $userId): UsersChat
    {
        $this->userId = $userId;
        return $this;
    }
    
    /**
     * Get userName
     *
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }
    
    /**
     * Set userName
     *
     * @param string $userName
     *
     * @return UsersChat
     */
    public function setUserName(string $userName): UsersChat
    {
        $this->userName = $userName;
        return $this;
    }
    
    /**
     * Get approved
     *
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->approved;
    }
    
    /**
     * Set approved
     *
     * @param bool $approved
     *
     * @return UsersChat
     */
    public function setApproved(bool $approved): UsersChat
    {
        $this->approved = $approved;
        return $this;
    }
    
    /**
     * Get languageCode
     *
     * @return string
     */
    public function getLanguageCode(): string
    {
        return $this->languageCode;
    }
    
    /**
     * Set languageCode
     *
     * @param string $languageCode
     *
     * @return UsersChat
     */
    public function setLanguageCode(string $languageCode): UsersChat
    {
        $this->languageCode = $languageCode;
        return $this;
    }
    
    /**
     * Get chatId
     *
     * @return int
     */
    public function getChatId(): int
    {
        return $this->chatId;
    }
    
    /**
     * Set chatId
     *
     * @param int $chatId
     *
     * @return UsersChat
     */
    public function setChatId(int $chatId): UsersChat
    {
        $this->chatId = $chatId;
        return $this;
    }
    
    /**
     * Get chatName
     *
     * @return string
     */
    public function getChatName(): string
    {
        return $this->chatName;
    }
    
    /**
     * Set chatName
     *
     * @param string $chatName
     *
     * @return UsersChat
     */
    public function setChatName(string $chatName): UsersChat
    {
        $this->chatName = $chatName;
        return $this;
    }
    
    
    
    
    
    
}