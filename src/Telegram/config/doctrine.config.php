<?php
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'doctrine' => [
        'driver' => [
            'telegram_entity_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Telegram/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    'Coderun\Telegram\Entity' => 'telegram_entity_driver'
                ]
            
            ],
        
        ],
    ]
];