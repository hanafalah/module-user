<?php

namespace Zahzah\ModuleUser\Resources;

use Illuminate\Http\Request;
use Zahzah\LaravelSupport\Resources\ApiResource;

class ShowUser extends ViewUser
{
    public function toArray(Request $request): array
    {
        $arr = [
        ];
        $arr = $this->mergeArray(parent::toArray($request),$arr);
        
        return $arr;
    }
}
