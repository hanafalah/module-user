<?php

namespace Hanafalah\ModuleUser\Contracts\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleUser\Data\ChangePasswordData;
use Hanafalah\ModuleUser\Data\UserData;
use Hanafalah\ModuleWarehouse\Models\ModelHasRoom\ModelHasRoom;

interface User extends DataManagement
{
    public function showUsingRelation(): array;
    public function viewUsingRelation(): array;
    public function getUser(): mixed;
    public function prepareShowUser(?Model $model = null, ?array $attributes = null): ModelHasRoom;
    public function showUser(?Model $model = null): array;
    public function prepareStoreUser(UserData $user_dto): Model;
    public function storeUser(?UserData $user_dto = null): array;
    public function prepareChangePassword(ChangePasswordData $change_password_dto): ?bool;
    public function changePassword(? ChangePasswordData $change_password_dto = null): ?bool;
    public function user(mixed $conditionals = null): Builder;
    public function getUserByUsernameId(string $username, mixed $user_id): ?Model;
    public function getUserByEmailId(string $email, mixed $user_id): ?Model;
    
}
