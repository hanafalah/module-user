<?php

namespace Zahzah\ModuleUser\Models\User;

use Zahzah\LaravelHasProps\Concerns\HasProps;
use Zahzah\LaravelSupport\Models\BaseModel;

use Zahzah\LaravelHasProps\Concerns\HasCurrent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zahzah\LaravelPermission\Concerns\HasRole;
use Zahzah\ModuleUser\Resources\UserReference\ShowUserReference;
use Zahzah\ModuleUser\Resources\UserReference\ViewUserReference;

class UserReference extends BaseModel{
    use HasProps, SoftDeletes, HasCurrent, HasRole;
    
    public function getConditions(): array{
        return ['reference_type','reference_id','user_id'];
    }

    protected $fillable = [
        'id','uuid','reference_type','reference_id','user_id','current'
    ];

    // protected static function booted(): void{
    //     parent::booted();
    //     static::addGlobalScope('current_tenant',function($query){
    //         if (isset(tenancy()->tenant)){
    //             $query->where('tenant_id',tenancy()->tenant->getKey());
    //         }
    //     });
    // }

    public function toViewApi(){
        return new ViewUserReference($this);
    }

    public function toShowApi(){
        return new ShowUserReference($this);
    }

    //EIGER SECTION
    public function reference(){return $this->morphTo();}
    public function user(){return $this->belongsToModel('User');}
    //END EIGER SECTION
}