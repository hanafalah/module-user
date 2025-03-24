<?php

namespace Hanafalah\ModuleUser\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleRegional\Data\AddressData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class ChangePasswordData extends Data{
    public function __construct(
        #[MapInputName('id')]
        #[MapName('id')]
        public mixed $id = null,
    
        #[MapInputName('password')]
        #[MapName('password')]
        public string $password,
    
        #[MapInputName('old_password')]
        #[MapName('old_password')]
        public string $old_password,

        #[MapInputName('password_confirmation')]
        #[MapName('password_confirmation')]
        public string $password_confirmation,
    ){}
}