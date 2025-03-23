<?php

use Hanafalah\ModuleUser\{
    Models\User as ModuleUserModels,
    Commands as ModuleUserCommands,
    Contracts
};

return [
    'app' => [
        'contracts' => [
            //ADD YOUR CONTRACTS HERE
            'user'           => Contracts\User::class,
            'user_reference' => Contracts\UserReference::class
        ],
    ],
    'commands' => [
        ModuleUserCommands\InstallMakeCommand::class
    ],
    'libs' => [
        'model' => 'Models',
        'contract' => 'Contracts'
    ],
    'database' => [
        'models' => [
            // 'User'           => ModuleUserModels\User::class,
            // 'UserReference'  => ModuleUserModels\UserReference::class
        ]
    ]
];
