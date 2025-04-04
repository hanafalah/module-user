<?php

namespace Hanafalah\ModuleUser\Models\User;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;

use Hanafalah\LaravelHasProps\Concerns\HasCurrent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelPermission\Concerns\HasRole;
use Hanafalah\ModuleUser\Resources\UserReference\{
    ViewUserReference, ShowUserReference
};

class UserReference extends BaseModel
{
    use HasProps, SoftDeletes, HasCurrent, HasRole;

    public function getConditions(): array{
        return ['reference_type', 'reference_id', 'user_id'];
    }

    protected $fillable = [
        'id','uuid','reference_type','reference_id',
        'user_id','workspace_type','workspace_id','current'
    ];

    protected $prop_attributes = [
        'Role' => [
            'id','name'
        ]
    ];

    public function getViewResource(){
        return ViewUserReference::class;
    }

    public function getShowResource(){
        return ShowUserReference::class;
    }

    public function reference(){return $this->morphTo();}
    public function user(){return $this->belongsToModel('User');}
    public function workspace(){return $this->morphTo();}
}
