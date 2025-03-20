<?php

namespace Hanafalah\ModuleUser\Resources\UserReference;

use Illuminate\Http\Request;
use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewUserReference extends ApiResource
{
    public function toArray(Request $request): array
    {
        $arr = [
            'id'             => $this->id,
            'uuid'           => $this->uuid,
            'reference_type' => $this->reference_type,
            'reference_id'   => $this->reference_id,
            'reference'      => $this->relationValidation('reference', function () {
                return $this->reference->toViewApi();
            }),
            'role' => $this->relationValidation('role', function () {
                return $this->role->toViewApi();
            }),
            'roles' => $this->relationValidation('roles', function () {
                return $this->roles->transform(function ($role) {
                    return $role->toViewApi();
                });
            }),
            'user_id'        => $this->user_id,
            'current'        => $this->current,
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at
        ];

        return $arr;
    }
}
