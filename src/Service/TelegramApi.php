<?php

declare(strict_types=1);

namespace Northmule\Telegram\Service;

use Laminas\Log\Logger;
use Laminas\ServiceManager\ServiceManager;
use Longman\TelegramBot\Telegram;

/**
 * Расширение базового класса для инъекции ServiceManager
 * Class TelegramApi
 *
 * @package Northmule\Telegram\Service
 */
class TelegramApi extends Telegram
{

    /**
     * @var ServiceManager
     */
    protected ServiceManager $serviceManager;
    /**
     * @var Logger
     */
    protected Logger $logger;

    public function __construct($api_key, $bot_username = '')
    {
        parent::__construct($api_key, $bot_username);
    }

    /**
     * Get serviceManager
     *
     * @return ServiceManager
     */
    public function getServiceManager(): ServiceManager
    {
        return $this->serviceManager;
    }

    /**
     * Set serviceManager
     *
     * @param ServiceManager $serviceManager
     *
     * @return TelegramApi
     */
    public function setServiceManager(ServiceManager $serviceManager): TelegramApi
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    /**
     * Get logger
     *
     * @return Logger
     */
    public function getLogger(): Logger
    {
        return $this->logger;
    }

    /**
     * Set logger
     *
     * @param Logger $logger
     *
     * @return TelegramApi
     */
    public function setLogger(Logger $logger): TelegramApi
    {
        $this->logger = $logger;
        return $this;
    }
}
