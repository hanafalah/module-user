<?php

namespace Hanafalah\ModuleUser\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleUser\Contracts\UserReference as ContractsUserReference;
use Hanafalah\ModuleUser\Supports\BaseModuleUser;

class UserReference extends BaseModuleUser implements ContractsUserReference
{
    protected array $__guard   = ['reference_type', 'reference_id', 'user_id'];
    protected array $__add     = [];
    protected string $__entity = 'UserReference';
    public static $user_reference;

    public function prepareStoreUserReference(?array $attributes = null): Model
    {
        $attributes ??= request()->all();

        if (isset($attributes['id'])) {
            $guard = ['id' => $attributes['id']];
        }

        if (isset($attributes['uuid'])) {
            $guard = ['uuid' => $attributes['uuid']];
        }

        if (!isset($attributes['id']) || !isset($attributes['uuid'])) {
            $guard = [
                'user_id'        => $attributes['user_id'],
                'reference_type' => $attributes['reference_type'],
                'reference_id'   => $attributes['reference_id']
            ];
            if (isset(tenancy()->tenant)) {
                $tenant = tenancy()->tenant;
                $guard['tenant_id'] = $tenant->getKey();
                $guard['central_tenant_id'] = $tenant->parent_id ?? null;
            }
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

        return static::$user_reference = $user_reference;
    }

    private function setRole($user_reference, $role)
    {
        $role = $this->RoleModel()->find($role);
        $user_reference->role_id   = $role->getKey();
        $user_reference->role_name = $role->name;
        $user_reference->save();
    }

    public function addOrChange(?array $attributes = []): self
    {
        static::$user_reference = $this->updateOrCreate($attributes);
        return $this;
    }

    public function getUserReference(): mixed
    {
        return static::$user_reference;
    }

    public function userReference(mixed $conditionals = null): Builder
    {
        $this->booting();
        return $this->UserReferenceModel()->conditionals($conditionals);
    }
}
