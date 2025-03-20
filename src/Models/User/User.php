<?php

namespace Zahzah\ModuleUser\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Zahzah\ApiHelper\Concerns\Token\HasApiTokens;
use Zahzah\ModuleUser\Concerns\UserReference\HasUserReference;
use Zahzah\ModuleUser\Resources\ShowUser;
use Zahzah\ModuleUser\Resources\ViewUser;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasUserReference;

    protected $fillable = ['username','email','password'];
    protected $hidden   = ['password','remember_token'];

    protected static function newFactory(){
        return \Zahzah\ModuleUser\Factories\UserFactory::new();
    }

    protected function casts(): array{
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed'
        ];
    }

    public function toViewApi(){
        return new ViewUser($this);
    }

    public function toShowApi(){
        return new ShowUser($this);
    }

    //EIGER SECTION
    public function userReference(){return $this->hasOneModel('UserReference')->where(function($q){
        if (isset(tenancy()->tenant)){
            $q->where('tenant_id',tenancy()->tenant->getKey());
        }
    });}
    public function userReferences(){return $this->hasManyModel('UserReference')->where(function($q){
        if (isset(tenancy()->tenant)){
            $q->where('tenant_id',tenancy()->tenant->getKey());
        }
    });}
    //END EIGER SECTION
}
