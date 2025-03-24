<?php

namespace Hanafalah\ModuleUser\Data;

use Carbon\Carbon;
use Hanafalah\LaravelPermission\Data\RoleData;
use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleRegional\Data\AddressData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

class UserReferenceData extends Data{
    public function __construct(
        #[MapInputName('id')]
        #[MapName('id')]
        public mixed $id = null,

        #[MapInputName('uuid')]
        #[MapName('uuid')]
        public ?string $uuid = null,
    
        #[MapInputName('user_id')]
        #[MapName('user_id')]
        public mixed $user_id,

        #[MapInputName('reference_type')]
        #[MapName('reference_type')]
        public string $reference_type,

        #[MapInputName('reference_id')]
        #[MapName('reference_id')]
        public mixed $reference_id,

        #[MapInputName('workspace_type')]
        #[MapName('workspace_type')]
        public ?string $workspace_type = null,

        #[MapInputName('workspace_id')]
        #[MapName('workspace_id')]
        public mixed $workspace_id = null,

        #[MapInputName('role')]
        #[MapName('role')]
        public ?RoleData $role = null,
    ){}
}