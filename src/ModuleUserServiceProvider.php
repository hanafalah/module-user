<?php

declare(strict_types=1);

namespace Hanafalah\ModuleUser;

use Hanafalah\LaravelSupport\Providers\BaseServiceProvider;

class ModuleUserServiceProvider extends BaseServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return $this
     */
    public function register()
    {
        $this->registerMainClass(ModuleUser::class)
            ->registerCommandService(Providers\CommandServiceProvider::class)
            ->registers([
                '*',
                'Services' => function () {
                    $this->binds([
                        Contracts\ModuleUser::class => new ModuleUser,
                        Contracts\User::class          => new Schemas\User,
                        Contracts\UserReference::class => new Schemas\UserReference
                    ]);
                }
            ]);
    }

    /**
     * Get the base path of the package.
     *
     * @return string
     */
    protected function dir(): string
    {
        return __DIR__ . '/';
    }
}
