<?php

namespace Hanafalah\ModuleUser\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Hanafalah\ModuleUser\Concerns\User\UserValidation;
use Hanafalah\ModuleUser\Contracts\User as ContractsUser;
use Hanafalah\ModuleUser\Contracts\UserReference as ContractsUserReference;
use Hanafalah\ModuleUser\Resources\ShowUser;
use Hanafalah\ModuleUser\Resources\ViewUser;
use Hanafalah\ModuleUser\Supports\BaseModuleUser;

class User extends BaseModuleUser implements ContractsUser
{
    use UserValidation;

    protected array $__guard   = ['username', 'email'];
    protected array $__add     = ['password', 'email_verified_at'];
    protected string $__entity = 'User';
    public static $user_model;

    protected array $__morphs  = [
        'UserReference' => UserReference::class
    ];

    protected array $__resources = [
        'view' => ViewUser::class,
        'show' => ShowUser::class
    ];

    public function showUsingRelation(): array
    {
        return [
            'userReference'
        ];
    }

    public function prepareShowUser(?Model $model = null, ?array $attributes = null): Model
    {
        $attributes ??= \request()->all();

        $model ??= $this->getUser();

        if (!isset($model)) {
            $id = $attributes['id'] ?? null;
            if (!isset($id)) throw new \Exception('User Id is required', 422);
            $model = $this->user()->with($this->showUsingRelation())->find($id);
        } else {
            $model->load($this->showUsingRelation());
        }
        return static::$user_model = $model;
    }

    public function showUser(?Model $model = null): array
    {
        return $this->transforming($this->__resources['show'], function () use ($model) {
            return $this->prepareShowUser($model);
        });
    }

    public function prepareStoreUser(?array $attributes = null): Model
    {
        $attributes ??= request()->all();

        if (isset($attributes['id'])) {
            $guard = ['id' => $attributes['id']];
        } else {
            $guard = [
                'username' => $attributes['username'],
                'email'    => $attributes['email']
            ];

            $add = [
                'email_verified_at' => $attributes['email_verified_at'] ?? null
            ];
        }

        if (!isset($attributes['id'])) {
            $add['password'] = Hash::make($attributes['password'] ?? 'password');
        } else {
            if (isset($attributes['password'])) $add['password'] = Hash::make($attributes['password']);
            $add['username'] = $attributes['username'];
            $add['email']    = $attributes['email'];
        }

        $user = $this->user()->updateOrCreate($guard, $add ?? []);
        if (isset($attributes['user_reference'])) {
            $attributes['user_reference']['user_id'] = $user->getKey();
            $user_reference = $this->schemaContract('user_reference');
            $user_reference_model = $user_reference->prepareStoreUserReference($attributes['user_reference']);
        }

        return static::$user_model = $user;
    }

    public function getUser(): mixed
    {
        return static::$user_model;
    }

    public function storeUser(): array
    {
        return $this->transaction(function () {
            return $this->showUser($this->prepareStoreUser());
        });
    }

    public function addOrChange(?array $attributes = []): self
    {
        $user = $this->updateOrCreate($attributes);
        static::$user_model = $user;
        return $this;
    }

    public function changePassword(?array $attributes = null): ?bool
    {
        $attributes ??= request()->all();

        if (!isset($attributes['id'])) throw new \Exception('User Id is required', 422);
        if (!$this->checkRequestPassword()) throw new \Exception('New Password, old password and new password confirmation is required', 422);

        return $this->UserModel()->updateOrCreate([
            'id' => static::$user_model->id
        ], [
            'password' => Hash::make($attributes['password'])
        ]);
    }

    private function checkRequestPassword(): bool
    {
        return request()->has('password') && request()->has('old_password') && request()->has('password_confirmation');
    }

    public function user(mixed $conditionals = null): Builder
    {
        return $this->UserModel()->conditionals($conditionals);
    }

    public function getUserByUsernameId(string $username, $user_id): ?Model
    {
        return $this->user()->where('username', $username)->find($user_id);
    }

    public function getUserByEmailId(string $email, $user_id): ?Model
    {
        return $this->user()->where('email', $email)->find($user_id);
    }
}
