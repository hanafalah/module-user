<?php

namespace Zahzah\ModuleUser\Resources\UserReference;

use Illuminate\Http\Request;

class ShowUserReference extends ViewUserReference
{
    public function toArray(Request $request): array
    {
        $arr = [
            'reference' => $this->relationValidation('reference',function(){
                return $this->reference->toShowApi();
            }),
            'role' => $this->relationValidation('role',function(){
                return $this->role->toShowApi();
            }),
            'roles' => $this->relationValidation('roles',function(){
                return $this->roles->transform(function($role){
                    return $role->toShowApi();
                });
            }),
            'user' => $this->relationValidation('user',function(){
                return $this->user->toShowApi();
            })
        ];
        $arr = $this->mergeArray(parent::toArray($request),$arr);
        
        return $arr;
    }
}
