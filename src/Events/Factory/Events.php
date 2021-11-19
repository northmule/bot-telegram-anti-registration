<?php

declare(strict_types=1);

namespace Northmule\Telegram\Events\Factory;

use Interop\Container\ContainerInterface;
use Laminas\Form\FormElementManager\FormElementManagerV3Polyfill;
use Laminas\Log\Logger;
use Laminas\Log\Writer\Stream;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Northmule\Telegram\Events\Events as EventsService;
use Northmule\Telegram\Options\ModuleOptions;

class Events implements FactoryInterface
{

    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        /** @var FormElementManagerV3Polyfill $formManager */
        $serviceManager = $container->get('ServiceManager');
        /** @var ModuleOptions $options */
        $options = $container->get(ModuleOptions::class);
        $logger = new Logger();
        if ($options->getFileLog()) {
            $logger->addWriter(
                new Stream($options->getFileLog())
            );
        }

        return new EventsService($serviceManager, $logger, $options);
    }
}
