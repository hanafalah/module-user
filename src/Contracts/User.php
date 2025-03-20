<?php

namespace Zahzah\ModuleUser\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Zahzah\LaravelSupport\Contracts\DataManagement;

interface User extends DataManagement
{
    public function isTakenUsing($user_id,callable $closure, bool $throw = false,?string $message = null): ? bool;
    public function isTakenByUsernameId(string $username, $user_id, bool $throw = false):? bool;
    public function isTakenByEmailId(string $email, $user_id, bool $throw = false):? bool;
    public function showUsingRelation(): array;
    public function prepareShowUser(? Model $model = null, ? array $attributes = null): Model;
    public function showUser(? Model $model = null): array;
    public function prepareStoreUser(? array $attributes = null): Model;
    public function getUser(): mixed;
    public function storeUser(): array;
    public function addOrChange(? array $attributes=[]): self;
    public function changePassword(? array $attributes = null): ? bool;
    public function user(mixed $conditionals = null): Builder;
    public function getUserByUsernameId(string $username, $user_id):? Model;
    public function getUserByEmailId(string $email, $user_id):? Model;
}