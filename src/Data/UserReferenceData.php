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
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('uuid')]
    #[MapName('uuid')]
    public ?string $uuid = null;
    
    #[MapInputName('user_id')]
    #[MapName('user_id')]
    public mixed $user_id = null;

    #[MapInputName('user')]
    #[MapName('user')]
    public ?UserData $user = null;

    #[MapInputName('reference_type')]
    #[MapName('reference_type')]
    public ?string $reference_type = null;

    #[MapInputName('reference_id')]
    #[MapName('reference_id')]
    public mixed $reference_id = null;

    #[MapInputName('workspace_type')]
    #[MapName('workspace_type')]
    public ?string $workspace_type = null;

    #[MapInputName('workspace_id')]
    #[MapName('workspace_id')]
    public mixed $workspace_id = null;

    #[MapInputName('role_ids')]
    #[MapName('role_ids')]
    public ?array $role_ids = [];

    #[MapInputName('roles')]
    #[MapName('roles')]
    #[WithTransformer(RoleDataTransformer::class)]
    public ?array $roles = [];
    
    public static function after(UserReferenceData $data): UserReferenceData{
        if (isset($data->user,$data->user->id) && !isset($data->user_id)){
            $data->user_id = $data->user->id;
        }

        if (!isset($data->roles) && !isset($data->role_ids)) throw new \Exception('roles or role_ids is required');

        if(!empty($data->role_ids)){
            $data->roles = $data->fetchRolesFromIds($data->role_ids);
        }
        if (empty($data->role_ids) && count($data->roles) > 0){
            $data->role_ids = \array_column($data->roles,'id');
        }
        return $data;
    }

    private function fetchRolesFromIds(array $roleIds): array{
        $roles = $this->RoleModel()->whereIn('id',$roleIds)->get();
        return $roles->map(fn($role) => RoleData::from($role))->toArray();
    }
}