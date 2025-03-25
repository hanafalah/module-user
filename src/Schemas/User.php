<?php

namespace Hanafalah\ModuleUser\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Hanafalah\ModuleUser\Concerns\User\UserValidation;
use Hanafalah\ModuleUser\Contracts\User as ContractsUser;
use Hanafalah\ModuleUser\Data\ChangePasswordData;
use Hanafalah\ModuleUser\Data\UserData;
use Hanafalah\ModuleUser\Resources\ShowUser;
use Hanafalah\ModuleUser\Resources\ViewUser;
use Hanafalah\ModuleUser\Supports\BaseModuleUser;
use Hanafalah\ModuleWarehouse\Models\ModelHasRoom\ModelHasRoom;

class User extends BaseModuleUser implements ContractsUser
{
    use UserValidation;

    protected array $__guard   = ['username', 'email'];
    protected array $__add     = ['password', 'email_verified_at'];
    protected string $__entity = 'User';
    public static $user_model;

    public function showUsingRelation(): array{
        return [
            'userReference'
        ];
    }

    public function viewUsingRelation(): array{
        return [];
    }

    public function getUser(): mixed{
        return static::$user_model;
    }

    public function prepareShowUser(?Model $model = null, ?array $attributes = null): ModelHasRoom{
        $attributes ??= \request()->all();

        $model ??= $this->getUser();
        if (!isset($model)) {
            $id = $attributes['id'] ?? null;
            if (!isset($id)) throw new \Exception('User Id is required', 422);
            $model = $this->user()->with($this->showUsingRelation())->findOrFail($id);
        } else {
            $model->load($this->showUsingRelation());
        }
        return static::$user_model = $model;
    }

    public function showUser(?Model $model = null): array{
        return $this->showEntityResource(function() use ($model){
            return $this->prepareShowUser($model);
        });
    }

    public function prepareStoreUser(UserData $user_dto): Model{
        if (isset($user_dto->id)) {
            $guard = ['id' => $user_dto->id];
        } else {
            $guard = [
                'username' => $user_dto->username,
                'email'    => $user_dto->email
            ];

            $add = [
                'email_verified_at' => $user_drot->email_verified_at ?? null
            ];
        }

        if (!isset($user_dto->id)) {
            $add['password'] = Hash::make($user_dto->password ?? 'password');
        } else {
            if (isset($user_dto->password)) $add['password'] = Hash::make($user_dto->password);
            $add['username'] = $user_dto->username;
            $add['email']    = $user_dto->email;
        }

        $user = $this->user()->updateOrCreate($guard, $add ?? []);
        if (isset($user_dto->user_reference)) {
            $user_dto->user_reference['user_id'] = $user->getKey();
            $this->schemaContract('user_reference')
                 ->prepareStoreUserReference($user_dto->user_reference);
        }

        return static::$user_model = $user;
    }

    public function storeUser(?UserData $user_dto = null): array{
        return $this->transaction(function() use ($user_dto){
            return $this->showUser($this->prepareStoreUser($user_dto ?? UserData::from(request()->all())));
        });
    }

    public function prepareChangePassword(ChangePasswordData $change_password_dto): ?bool{
        if (!isset($change_password_dto->id)) throw new \Exception('User Id is required', 422);
        if (!$this->checkRequestPassword()) throw new \Exception('New Password, old password and new password confirmation is required', 422);

        return $this->UserModel()->updateOrCreate([
            'id' => $change_password_dto->id
        ], [
            'password' => Hash::make($change_password_dto->password)
        ]);
    }

    public function changePassword(? ChangePasswordData $change_password_dto = null): ?bool{
        return $this->transaction(function() use ($change_password_dto){
            return $this->prepareChangePassword($change_password_dto ?? ChangePasswordData::from(request()->all()));
        });
    }

    private function checkRequestPassword(): bool{
        return request()->has('password') && request()->has('old_password') && request()->has('password_confirmation');
    }

    public function user(mixed $conditionals = null): Builder{
        $this->booting();
        return $this->UserModel()->conditionals($this->mergeCondition($conditionals ?? []))->withParameters();
    }

    public function getUserByUsernameId(string $username, mixed $user_id): ?Model{
        return $this->user()->where('username', $username)->find($user_id);
    }

    public function getUserByEmailId(string $email, mixed $user_id): ?Model{
        return $this->user()->where('email', $email)->find($user_id);
    }
}
