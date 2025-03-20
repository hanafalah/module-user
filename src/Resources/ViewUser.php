<?php

namespace Zahzah\ModuleUser\Resources;

use Illuminate\Http\Request;
use Zahzah\LaravelSupport\Resources\ApiResource;

class ViewUser extends ApiResource
{
    public function toArray(Request $request): array
    {
        $arr = [
            'id'                => $this->id,
            'username'          => $this->username,
            'email'             => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'user_reference'    => $this->relationValidation('userReference',function(){
                return $this->userReference->toViewApi();
            })
        ];
        
        return $arr;
    }
}
