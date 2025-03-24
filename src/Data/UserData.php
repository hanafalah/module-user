<?php

namespace Hanafalah\ModuleUser\Data;

use Carbon\Carbon;
use Hanafalah\LaravelSupport\Supports\Data;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

class UserData extends Data{
    public function __construct(
        #[MapInputName('id')]
        #[MapName('id')]
        public mixed $id = null,
    
        #[MapInputName('username')]
        #[MapName('username')]
        public string $username,
    
        #[MapInputName('password')]
        #[MapName('password')]
        #[Password]
        public ?string $password = null,

        #[MapInputName('email')]
        #[MapName('email')]
        #[Email]
        public string $email,

        #[MapInputName('email_verified_at')]
        #[MapName('email_verified_at')]
        #[WithTransformer(DateTimeInterfaceTransformer::class)]
        public ?Carbon $email_verified_at = null,

        #[MapInputName('user_reference')]
        #[MapName('user_reference')]
        public UserReferenceData $user_reference
    ){}
}