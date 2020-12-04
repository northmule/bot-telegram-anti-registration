<?php
return [
    'view_manager' => [
        'template_map' => [
            'telegram/index/json'             => __DIR__ .'/../view/telegram/index/json.phtml',
        ],
        'template_path_stack' => [
            Coderun\Telegram\Module::class => __DIR__ .'/../view',
        ],
    
    ],
];


