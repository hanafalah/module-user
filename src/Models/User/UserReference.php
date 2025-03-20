<?php

namespace Hanafalah\ModuleUser\Models\User;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;

use Hanafalah\LaravelHasProps\Concerns\HasCurrent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelPermission\Concerns\HasRole;
use Hanafalah\ModuleUser\Resources\UserReference\ShowUserReference;
use Hanafalah\ModuleUser\Resources\UserReference\ViewUserReference;

class UserReference extends BaseModel
{
    use HasProps, SoftDeletes, HasCurrent, HasRole;

    public function getConditions(): array
    {
        return ['reference_type', 'reference_id', 'user_id'];
    }

    protected $fillable = [
        'id',
        'uuid',
        'reference_type',
        'reference_id',
        'user_id',
        'current'
    ];

    // protected static function booted(): void{
    //     parent::booted();
    //     static::addGlobalScope('current_tenant',function($query){
    //         if (isset(tenancy()->tenant)){
    //             $query->where('tenant_id',tenancy()->tenant->getKey());
    //         }
    //     });
    // }

    public function toViewApi()
    {
        return new ViewUserReference($this);
    }

    public function toShowApi()
    {
        return new ShowUserReference($this);
    }

    //EIGER SECTION
    public function reference()
    {
        return $this->morphTo();
    }
    public function user()
    {
        return $this->belongsToModel('User');
    }
    //END EIGER SECTION
}
