<?php
namespace Northmule\Telegram\Events\Factory;


use Interop\Container\ContainerInterface;
use Laminas\Log\Logger;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Northmule\Telegram\Events\Events as EventsService;
use Northmule\Telegram\Options\ModuleOptions;


class Events implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        /** @var \Laminas\Form\FormElementManager\FormElementManagerV3Polyfill $formManager */
        $serviceManager = $container->get('ServiceManager');
        /** @var \Northmule\Telegram\Options\ModuleOptions $options */
        $options = $container->get(ModuleOptions::class);
        $logger = new Logger();
        if ($options->getFileLog()) {
            $logger->addWriter(new \Laminas\Log\Writer\Stream($options->getFileLog()));
        }

        return new EventsService($serviceManager,$logger);
    }
}