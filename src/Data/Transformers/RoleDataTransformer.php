<?php

namespace Hanafalah\ModuleUser\Data\Transformers;

use Hanafalah\LaravelPermission\Data\RoleData;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Transformers\Transformer;

class RoleDataTransformer extends Transformer
{
    public function transform(DataProperty $property, mixed $value): array
    {
        // Jika data null, kembalikan array kosong
        if (is_null($value)) {
            return [];
        }

        // Jika data adalah array, transformasi ke RoleData
        return collect($value)
            ->map(fn ($role) => RoleData::from($role))
            ->toArray();
    }
}
