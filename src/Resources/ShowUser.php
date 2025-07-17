<?php

namespace Hanafalah\ModuleUser\Resources;

use Illuminate\Http\Request;
use Hanafalah\LaravelSupport\Resources\ApiResource;

class ShowUser extends ViewUser
{
    public function toArray(Request $request): array
    {
        $arr = [];
        $arr = $this->mergeArray(parent::toArray($request), $arr);
        return $arr;
    }
}
