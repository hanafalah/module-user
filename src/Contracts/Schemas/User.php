<?php

namespace Hanafalah\ModuleUser\Contracts\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleUser\Contracts\Data\ChangePasswordData;
use Hanafalah\ModuleUser\Contracts\Data\UserData;

/**
 * @see \Hanafalah\ModuleUser\Schemas\User
 * @method self conditionals(mixed $conditionals)
 * @method array storeUser(?UserData $rab_work_list_dto = null)
 * @method bool deleteUser()
 * @method bool prepareDeleteUser(? array $attributes = null)
 * @method mixed getUser()
 * @method ?Model prepareShowUser(?Model $model = null, ?array $attributes = null)
 * @method array showUser(?Model $model = null)
 * @method array viewUserList()
 * @method Collection prepareViewUserList(? array $attributes = null)
 * @method LengthAwarePaginator prepareViewUserPaginate(PaginateData $paginate_dto)
 * @method array viewUserPaginate(?PaginateData $paginate_dto = null)
 * @method Builder function user(mixed $conditionals = null)
 */
interface User extends DataManagement
{
    public function prepareStoreUser(UserData $user_dto): Model;
    public function prepareChangePassword(ChangePasswordData $change_password_dto): ?bool;
    public function changePassword(? ChangePasswordData $change_password_dto = null): ?bool;
    public function getUserByUsernameId(string $username, mixed $user_id): ?Model;
    public function getUserByEmailId(string $email, mixed $user_id): ?Model;
}
