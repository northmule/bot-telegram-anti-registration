<?php

namespace Northmule\Telegram\Controller\Factory;

use Exception;
use Interop\Container\ContainerInterface;
use Laminas\Form\FormElementManager\FormElementManagerV3Polyfill;
use Laminas\Log\Logger;
use Laminas\Log\Writer\Stream;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Longman\TelegramBot\Exception\TelegramException;
use Northmule\Telegram\Controller\Bot as BotController;
use Northmule\Telegram\Options\ModuleOptions;
use Northmule\Telegram\Service\TelegramApi;

class Bot implements FactoryInterface
{

    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        /** @var ModuleOptions $options */
        $options = $container->get(ModuleOptions::class);
        /** @var FormElementManagerV3Polyfill $formManager */
        $serviceManager = $container->get('ServiceManager');
        $logger = new Logger();
        if ($options->getTelegramLog()) {
            $logger->addWriter(
                new Stream($options->getTelegramLog())
            );
        }

        try {
            $telegram = $container->get(TelegramApi::class);
            $telegram->addCommandsPaths($options->getCommandsPath());
        } catch (TelegramException $e) {
            throw new Exception($e);
        }


        $class = new BotController(
            $serviceManager,
            $logger,
            $telegram
        );

        return $class;
    }
}
