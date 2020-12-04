<?php
return [
    'view_manager' => [
        'template_map' => [
            'telegram/index/json'             => __DIR__ .'/../src/view/telegram/index/json.phtml',
        ],
        'template_path_stack' => [
            Northmule\Telegram\Module::class => __DIR__ .'/../src/view',
        ],
    
    ],
];


