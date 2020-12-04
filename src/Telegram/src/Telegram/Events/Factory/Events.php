<?php
namespace Coderun\Telegram\Events\Factory;


use Interop\Container\ContainerInterface;
use Laminas\Log\Logger;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Coderun\Telegram\Events\Events as EventsService;
use Coderun\Telegram\Options\ModuleOptions;


class Events implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        /** @var \Laminas\Form\FormElementManager\FormElementManagerV3Polyfill $formManager */
        $serviceManager = $container->get('ServiceManager');
        /** @var \Coderun\Telegram\Options\ModuleOptions $options */
        $options = $container->get(ModuleOptions::class);
        $logger = new Logger();
        if ($options->getFileLog()) {
            $logger->addWriter(new \Laminas\Log\Writer\Stream($options->getFileLog()));
        }

        return new EventsService($entityManager,$serviceManager,$logger);
    }
}