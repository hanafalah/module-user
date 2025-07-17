<?php

namespace Hanafalah\ModuleUser\Models\User;

use Illuminate\Auth\Authenticatable as AuthAuthenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Hanafalah\LaravelSupport\Models\BaseModel;

class Authenticatable extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use AuthAuthenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
}
