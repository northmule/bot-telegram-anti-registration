<?php

declare(strict_types=1);

namespace Northmule\Telegram\Service\Factory;


use Interop\Container\ContainerInterface;
use Laminas\Log\Logger;
use Laminas\Log\Writer\Stream;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Northmule\Telegram\Options\ModuleOptions;
use Northmule\Telegram\Service\TelegramApi as TelegramApiService;

class TelegramApi implements FactoryInterface
{
    
    
    public function __invoke(ContainerInterface $container, $requestedName,
        array $options = null
    ) {
        /** @var ModuleOptions $options */
        $options = $container->get(ModuleOptions::class);
        
        $telegram = new TelegramApiService(
            $options->getApiKey(), $options->getBotUsername()
        );
        $telegram->setServiceManager($container);
        
        $options = $container->get(ModuleOptions::class);
        $logger = new Logger();
        if ($options->getFileLog()) {
            $logger->addWriter(
                new Stream($options->getFileLog())
            );
            $telegram->setLogger($logger);
        }
        
        return $telegram;
        
    }
    
}