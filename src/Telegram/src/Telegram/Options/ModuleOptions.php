<?php
declare(strict_types=1);

namespace Coderun\Telegram\Options;

use Laminas\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    protected $apiKey;
    protected $botUsername;
    protected $bootHookUrl;
    protected $commandsPath;
    protected $telegramLog;
    protected $fileLog;
    
    /**
     * Get apiKey
     *
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }
    
    /**
     * Set apiKey
     *
     * @param mixed $apiKey
     *
     * @return ModuleOptions
     */
    public function setApiKey($apiKey): ModuleOptions
    {
        $this->apiKey = $apiKey;
        return $this;
    }
    
    /**
     * Get botUsername
     *
     * @return mixed
     */
    public function getBotUsername()
    {
        return $this->botUsername;
    }
    
    /**
     * Set botUsername
     *
     * @param mixed $botUsername
     *
     * @return ModuleOptions
     */
    public function setBotUsername($botUsername): ModuleOptions
    {
        $this->botUsername = $botUsername;
        return $this;
    }
    
    /**
     * Get bootHookUrl
     *
     * @return mixed
     */
    public function getBootHookUrl()
    {
        return $this->bootHookUrl;
    }
    
    /**
     * Set bootHookUrl
     *
     * @param mixed $bootHookUrl
     *
     * @return ModuleOptions
     */
    public function setBootHookUrl($bootHookUrl): ModuleOptions
    {
        $this->bootHookUrl = $bootHookUrl;
        return $this;
    }
    
    /**
     * Get commandsPath
     *
     * @return mixed
     */
    public function getCommandsPath()
    {
        return $this->commandsPath;
    }
    
    /**
     * Set commandsPath
     *
     * @param mixed $commandsPath
     *
     * @return ModuleOptions
     */
    public function setCommandsPath($commandsPath): ModuleOptions
    {
        $this->commandsPath = $commandsPath;
        return $this;
    }
    
    /**
     * Get telegramLog
     *
     * @return mixed
     */
    public function getTelegramLog()
    {
        return $this->telegramLog;
    }
    
    /**
     * Set telegramLog
     *
     * @param mixed $telegramLog
     *
     * @return ModuleOptions
     */
    public function setTelegramLog($telegramLog): ModuleOptions
    {
        $this->telegramLog = $telegramLog;
        return $this;
    }
    
    /**
     * Get fileLog
     *
     * @return mixed
     */
    public function getFileLog()
    {
        return $this->fileLog;
    }
    
    /**
     * Set fileLog
     *
     * @param mixed $fileLog
     *
     * @return ModuleOptions
     */
    public function setFileLog($fileLog): ModuleOptions
    {
        $this->fileLog = $fileLog;
        return $this;
    }
    
    
    
    
}