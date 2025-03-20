<?php

namespace Hanafalah\ModuleUser\Concerns\UserReference;

trait HasUserReference
{
    //SCOPE SECTION
    public function scopeHasRefUuid($builder, $uuid, $uuid_name = 'uuid')
    {
        return $builder->whereHas('userReference', function ($query) use ($uuid_name, $uuid) {
            $query->where($uuid_name, $uuid);
        });
    }

    //EIGER SECTION
    public function userReference()
    {
        return $this->morphOneModel('UserReference', 'reference');
    }
    public function userReferences()
    {
        return $this->morphManyModel('UserReference', 'reference');
    }

    public function user()
    {
        return $this->hasOneThroughModel(
            'User',
            'UserReference',
            'reference_id',
            $this->getKeyName(),
            $this->getKeyName(),
            $this->getForeignKey()
        )->where('reference_type', $this->getMorphClass());
    }
}
