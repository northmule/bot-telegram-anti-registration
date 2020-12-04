<?php
declare(strict_types=1);

namespace Coderun\Telegram\Options\Factory;



use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Coderun\Telegram\Options\ModuleOptions as Options;

class ModuleOptions implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null )
    {
        $appConfig = $container->get('config');
        $moduleConfig = array_merge(
            [],
            $appConfig['telegramBot']??[],
            $appConfig['telegramBot']['logger']??[]
        );
        return new Options($moduleConfig);
    }
    
}