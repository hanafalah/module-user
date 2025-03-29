<?php

namespace Hanafalah\ModuleUser\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleUser\Contracts\Data\UserReferenceData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface UserReference extends DataManagement {
    public function getUserReference(): mixed;
    public function prepareShowUsingReference(? Model $model = null, ? array $attributes = null): Model;
    public function showUserReference(?Model $model = null): array;
    public function prepareStoreUserReference(UserReferenceData $user_reference_dto): Model;
    public function storeUserReference(? UserReferenceData $user_reference_dto): array;
    public function userReference(mixed $conditionals = null): Builder;
}
