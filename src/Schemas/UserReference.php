<?php

namespace Hanafalah\ModuleUser\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleUser\Contracts\UserReference as ContractsUserReference;
use Hanafalah\ModuleUser\Data\UserReferenceData;
use Hanafalah\ModuleUser\Supports\BaseModuleUser;

class UserReference extends BaseModuleUser implements ContractsUserReference
{
    protected array $__guard   = ['reference_type', 'reference_id', 'user_id'];
    protected array $__add     = [];
    protected string $__entity = 'UserReference';
    public static $user_reference_model;

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return ['reference','workspace'];
    }

    public function getUserReference(): mixed{
        return static::$user_reference_model;
    }

    public function prepareShowUsingReference(? Model $model = null, ? array $attributes = null): Model{
        $attributes ??= request()->all();
        $model ??= $this->getUserReference();
        if (!isset($model)){
            $uuid = $attributes['uuid'] ?? null;
            if (!isset($uuid)) throw new \Exception('uuid is required');
            $model = $this->userReference()->with($this->showUsingRelation())->uuid($uuid)->firstOrFail();
        }else{
            $model->load($this->showUsingRelation());
        }
        return static::$user_reference_model = $model;
    }

    public function showUserReference(?Model $model = null): array{
        return $this->showEntityResource(function() use ($model){
            return $this->prepareShowUserReference($model);
        });
    }

    public function prepareStoreUserReference(UserReferenceData $user_reference_dto): Model{
        if (isset($user_reference_dto->id)) {
            $guard = ['id' => $user_reference_dto->id];
        }

        if (isset($user_reference_dto->uuid)) {
            $guard = ['uuid' => $user_reference_dto->uuid];
        }

        if (!isset($user_reference_dto->id) || !isset($user_reference_dto->uuid)) {
            $guard = [
                'user_id'        => $user_reference_dto->user_id,
                'reference_type' => $user_reference_dto->reference_type,
                'reference_id'   => $user_reference_dto->reference_id,
                'workspace_type' => $user_reference_dto->workspace_type,
                'workspace_id'   => $user_reference_dto->workspace_id
            ];
        }
        $user_reference = $this->userReference()->updateOrCreate($guard);

        if (isset($attributes['role'])) {
            $this->setRole($user_reference, $attributes['role']);
        } else {
            $user_reference->role_id   = null;
            $user_reference->role_name = null;
        }

        if (isset($attributes['roles'])) {
            $this->setRole($user_reference, $attributes['roles'][0]);
            $user_reference->syncRoles($attributes['roles']);
        } else {
            $user_reference->roles()->detach();
        }

        return static::$user_reference_model = $user_reference;
    }

    public function storeUserReference(? UserReferenceData $user_reference_dto): array{
        return $this->transaction(function() use ($user_reference_dto){
            return $this->showUserReference($this->prepareStoreUserReference($user_reference_dto ?? $this->requestDTO(UserReferenceData::class)));
        });
    }

    private function setRole($user_reference, $role){
        $role = $this->RoleModel()->find($role);
        $user_reference->role_id   = $role->getKey();
        $user_reference->role_name = $role->name;
        $user_reference->save();
    }    

    public function userReference(mixed $conditionals = null): Builder{
        $this->booting();
        return $this->UserReferenceModel()->conditionals($this->mergeCondition($conditionals ?? []));
    }
}
