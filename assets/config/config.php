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
        ],
    ],
    'commands' => [
        ModuleUserCommands\InstallMakeCommand::class
    ],
    'libs' => [
        'model'    => 'Models',
        'contract' => 'Contracts',
        'schema'   => 'Schemas'
    ],
    'database' => [
        'models' => [
            //ADD YOUR MODELS HERE
        ]
    ]
];
