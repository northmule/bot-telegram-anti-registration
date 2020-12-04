<?php
namespace Coderun\Telegram\Controller\Factory;


use Coderun\Telegram\Service\TelegramApi;
use Interop\Container\ContainerInterface;
use Laminas\Log\Logger;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Longman\TelegramBot\Exception\TelegramException;
use Coderun\Telegram\Controller\Bot as BotController;
use Coderun\Telegram\Options\ModuleOptions;



class Bot implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var \Coderun\Telegram\Options\ModuleOptions $options */
        $options = $container->get(ModuleOptions::class);
        $config = $container->get('config');
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        /** @var \Laminas\Form\FormElementManager\FormElementManagerV3Polyfill $formManager */
        $serviceManager = $container->get('ServiceManager');
        $logger = new Logger();
        if ($options->getTelegramLog()) {
            $logger->addWriter(new \Laminas\Log\Writer\Stream($options->getTelegramLog()));
        }
        
        try {
            $telegram = $container->get(TelegramApi::class);
            $telegram->addCommandsPaths($options->getCommandsPath());
        } catch (TelegramException $e) {
            throw new \Exception($e);
        }
    
    
        $class = new BotController(
            $entityManager,
            $serviceManager,
            $logger,
            $telegram
        );
        
        return $class;
    }
}