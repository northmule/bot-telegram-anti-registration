<?php

namespace Northmule\Telegram\Controller\Factory;


use Interop\Container\ContainerInterface;
use Laminas\Form\FormElementManager\FormElementManagerV3Polyfill;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Northmule\Telegram\Controller\Service as ServiceController;


class Service implements FactoryInterface
{
    
    public function __invoke(ContainerInterface $container, $requestedName,
        array $options = null
    ) {
        /** @var FormElementManagerV3Polyfill $formManager */
        $serviceManager = $container->get('ServiceManager');
        $class = new ServiceController(
            $serviceManager
        );
        
        return $class;
    }
    
}