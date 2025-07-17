<?php

namespace Hanafalah\ModuleUser\Data\Transformers;

use Hanafalah\LaravelPermission\Data\RoleData;
use Hanafalah\ModuleUser\Contracts\Data\Transformers\RoleDataTransformer as TransformersRoleDataTransformer;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\Transformation\TransformationContext;
use Spatie\LaravelData\Transformers\Transformer;

class RoleDataTransformer implements TransformersRoleDataTransformer,Transformer
{
    /**
     * Transform the given value into the desired format.
     *
     * @param DataProperty $property
     * @param mixed $value
     * @param array $context
     * @return mixed
     */
    public function transform(DataProperty $property, mixed $value, TransformationContext $context): mixed
    {
        // Jika data null, kembalikan array kosong
        if (is_null($value)) {
            return [];
        }

        // Jika data adalah array, transformasi setiap elemen menjadi RoleData
        if (is_array($value)) {
            return collect($value)
                ->map(fn ($role) => RoleData::from($role))
                ->toArray();
        }

        // Jika data adalah satu instance RoleData, kembalikan apa adanya
        if ($value instanceof RoleData) {
            return $value;
        }

        // Jika nilai tidak sesuai, lemparkan exception
        throw new \InvalidArgumentException('Invalid value provided for RoleDataTransformer.');
    }
}
