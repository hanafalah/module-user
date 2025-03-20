<?php

namespace Hanafalah\ModuleUser\Supports;

use Hanafalah\LaravelSupport\Supports\PackageManagement;

class BaseModuleUser extends PackageManagement
{
    /** @var array */
    protected $__module_user_config = [];

    /**
     * A description of the entire PHP function.
     *
     * @param Container $app The Container instance
     * @throws Exception description of exception
     * @return void
     */
    public function __construct()
    {
        $this->setConfig('module-user', $this->__module_user_config);
    }
}
