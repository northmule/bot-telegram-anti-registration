<?php

declare(strict_types=1);

namespace Northmule\Telegram\Service\Factory;


use Laminas\Log\Logger;
use Northmule\Telegram\Options\ModuleOptions;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Northmule\Telegram\Service\TelegramApi as TelegramApiService;

class TelegramApi implements FactoryInterface
{
    
    
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var \Northmule\Telegram\Options\ModuleOptions $options */
        $options = $container->get(ModuleOptions::class);
        
        $telegram = new TelegramApiService($options->getApiKey(),$options->getBotUsername());
        $telegram->setServiceManager($container);
    
        $options = $container->get(ModuleOptions::class);
        $logger = new Logger();
        if ($options->getFileLog()) {
            $logger->addWriter(new \Laminas\Log\Writer\Stream($options->getFileLog()));
            $telegram->setLogger($logger);
        }
        
        return $telegram;
        
    }
    
}