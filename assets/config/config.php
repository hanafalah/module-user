<?php

use Hanafalah\ModuleUser\{
    Models\User as ModuleUserModels,
    Commands as ModuleUserCommands,
    Contracts
};

return [
    'contracts' => [
        'user'           => Contracts\User::class,
        'user_reference' => Contracts\UserReference::class
    ],
    'commands' => [
        ModuleUserCommands\InstallMakeCommand::class
    ],
    'database' => [
        'models' => [
            'User'           => ModuleUserModels\User::class,
            'UserReference'  => ModuleUserModels\UserReference::class
        ]
    ]
];
