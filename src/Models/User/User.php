<?php

namespace Hanafalah\ModuleUser\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Hanafalah\ApiHelper\Concerns\Token\HasApiTokens;
use Hanafalah\ModuleUser\Concerns\UserReference\HasUserReference;
use Hanafalah\ModuleUser\Resources\ShowUser;
use Hanafalah\ModuleUser\Resources\ViewUser;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = ['username', 'email', 'password'];
    protected $hidden   = ['password', 'remember_token'];

    protected $casts = [
        'email'             => 'string',        
        'username'          => 'string',        
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    protected static function newFactory(){
        return \Hanafalah\ModuleUser\Factories\UserFactory::new();
    }

    // protected function casts(): array
    // {
    //     return [
    //         'email_verified_at' => 'datetime',
    //         'password'          => 'hashed'
    //     ];
    // }

    public function getViewResource(){
        return ViewUser::class;
    }

    public function getShowResource(){
        return ShowUser::class;
    }

    //EIGER SECTION
    public function userReference(){
        return $this->hasOneModel('UserReference');
    }
    public function userReferences(){
        return $this->hasManyModel('UserReference');
    }
    //END EIGER SECTION
}
