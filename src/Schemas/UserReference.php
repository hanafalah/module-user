<?php

namespace Hanafalah\ModuleUser\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleUser\Contracts\Schemas\UserReference as ContractsUserReference;
use Hanafalah\ModuleUser\Contracts\Data\UserReferenceData;
use Hanafalah\ModuleUser\Supports\BaseModuleUser;

class UserReference extends BaseModuleUser implements ContractsUserReference
{
    protected string $__entity = 'UserReference';
    public $user_reference_model;

    public function prepareShowUserReference(? Model $model = null, ? array $attributes = null): Model{
        $attributes ??= request()->all();
        $model ??= $this->getUserReference();
        if (!isset($model)){
            $uuid = $attributes['uuid'] ?? null;
            if (!isset($uuid)) throw new \Exception('uuid is required');
            $model = $this->userReference()->with($this->showUsingRelation())->uuid($uuid)->firstOrFail();
        }else{
            $model->load($this->showUsingRelation());
        }
        return $this->user_reference_model = $model;
    }


    public function prepareStoreUserReference(UserReferenceData $user_reference_dto): Model{
        if (isset($user_reference_dto->id) || isset($user_reference_dto->uuid)) {
            $user_reference = $this->UserReferenceModel()
                ->when(isset($user_reference_dto->uuid),function($query) use ($user_reference_dto){
                    return $query->where('uuid',$user_reference_dto->uuid);
                })
                ->when(isset($user_reference_dto->id),function($query) use ($user_reference_dto){
                    return $query->where('id', $user_reference_dto->id);
                })
                ->firstOrFail();            
            $user_reference->workspace_id   ??= $user_reference_dto->workspace_id ?? null;
            $user_reference->workspace_type ??= $user_reference_dto->workspace_type ?? null;
        }else{
            $guard = [
                'user_id'        => $user_reference_dto->user_id,
                'reference_type' => $user_reference_dto->reference_type,
                'reference_id'   => $user_reference_dto->reference_id,
                'workspace_type' => $user_reference_dto->workspace_type,
                'workspace_id'   => $user_reference_dto->workspace_id
            ];
            $user_reference = $this->userReference()->updateOrCreate($guard);
        }
        if (isset($user_reference_dto->roles) && count($user_reference_dto->roles) > 0) {
            $role = end($user_reference_dto->roles);
            $this->setRole($user_reference, $role['id']);
            $user_reference->syncRoles($user_reference_dto->role_ids);
        } else {
            $user_reference->roles()->detach();
            $user_reference->prop_role['id']   = null;
            $user_reference->prop_role['name']   = null;
        }
        if (isset($user_reference_dto->user)){
            $user_reference_dto->user->id ??= $user_reference_dto->user_id ?? null;
            $user_model = $this->schemaContract('user')->prepareStoreUser($user_reference_dto->user);
            $user_reference->user_id ??= $user_model->getKey();
        }
        $user_reference->save();
        return $this->user_reference_model = $user_reference;
    }

    private function setRole($user_reference, $role){
        $role = $this->RoleModel()->findOrFail($role);
        $user_reference->sync($role);
    }    
}
