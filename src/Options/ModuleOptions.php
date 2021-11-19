<?php

declare(strict_types=1);

namespace Northmule\Telegram\Options;

use Laminas\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{

    protected $apiKey;
    protected $botUsername;
    protected $bootHookUrl;
    protected $commandsPath;
    protected $telegramLog;
    protected $fileLog;
    protected $logger;
    protected $disableRouteSet;

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

    /**
     * Get logger
     *
     * @return mixed
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * Set logger
     *
     * @param mixed $logger
     *
     * @return ModuleOptions
     */
    public function setLogger($logger): ModuleOptions
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * Get disableRouteSet
     *
     * @return mixed
     */
    public function getDisableRouteSet()
    {
        return $this->disableRouteSet;
    }

    /**
     * Set disableRouteSet
     *
     * @param mixed $disableRouteSet
     *
     * @return ModuleOptions
     */
    public function setDisableRouteSet($disableRouteSet): ModuleOptions
    {
        $this->disableRouteSet = $disableRouteSet;
        return $this;
    }
}
