<?php

namespace Hanafalah\ModuleUser\Data;

use Hanafalah\LaravelPermission\Data\RoleData;
use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleUser\Contracts\Data\UserReferenceData as DataUserReferenceData;
use Hanafalah\ModuleUser\Data\Transformers\RoleDataTransformer;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\WithTransformer;

class UserReferenceData extends Data implements DataUserReferenceData{
    public function __construct(
        #[MapInputName('id')]
        #[MapName('id')]
        public mixed $id = null,

        #[MapInputName('uuid')]
        #[MapName('uuid')]
        public ?string $uuid = null,
    
        #[MapInputName('user_id')]
        #[MapName('user_id')]
        public mixed $user_id = null,

        #[MapInputName('reference_type')]
        #[MapName('reference_type')]
        public ?string $reference_type = null,

        #[MapInputName('reference_id')]
        #[MapName('reference_id')]
        public mixed $reference_id = null,

        #[MapInputName('workspace_type')]
        #[MapName('workspace_type')]
        public ?string $workspace_type = null,

        #[MapInputName('workspace_id')]
        #[MapName('workspace_id')]
        public mixed $workspace_id = null,

        #[MapInputName('role_ids')]
        #[MapName('role_ids')]
        public ?array $role_ids = [],

        #[MapInputName('roles')]
        #[MapName('roles')]
        #[WithTransformer(RoleDataTransformer::class)]
        public ?array $roles = [],
    ){
        if(!empty($this->role_ids)){
            $this->roles = $this->fetchRolesFromIds($this->role_ids);
        }
        if (empty($this->role_ids) && count($this->roles) > 0){
            $this->role_ids = \array_column($this->roles,'id');
        }
    }

    private function fetchRolesFromIds(array $roleIds): array
    {
        $roles = $this->RoleModel()->whereIn('id',$roleIds)->get();
        return $roles->map(fn($role) => RoleData::from($role))->toArray();
    }
}