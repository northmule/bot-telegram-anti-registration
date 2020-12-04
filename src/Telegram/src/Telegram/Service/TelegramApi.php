<?php

declare(strict_types=1);

namespace Coderun\Telegram\Service;

use Laminas\ServiceManager\ServiceManager;
use Longman\TelegramBot\Telegram;

/**
 * Расширение базового класса для инъекции ServiceManager
 * Class TelegramApi
 *
 * @package Coderun\Telegram\Service
 */
class TelegramApi extends Telegram
{
    
    /**
     * @var ServiceManager
     */
    protected $serviceManager;
    
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
    public function setServiceManager(ServiceManager $serviceManager
    ): TelegramApi {
        $this->serviceManager = $serviceManager;
        return $this;
    }
    

    
    
}