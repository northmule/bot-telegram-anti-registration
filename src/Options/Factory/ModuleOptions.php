<?php

declare(strict_types=1);

namespace Northmule\Telegram\Options\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Northmule\Telegram\Options\ModuleOptions as Options;

class ModuleOptions implements FactoryInterface
{

    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        $appConfig = $container->get('config');
        $moduleConfig = array_merge(
            [],
            $appConfig['telegramBot'] ?? [],
            $appConfig['telegramBot']['logger'] ?? [],
        );
        return new Options($moduleConfig);
    }
}
