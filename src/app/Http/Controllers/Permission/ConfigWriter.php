<?php

namespace LaravelEnso\Roles\App\Http\Controllers\Permission;

use LaravelEnso\Roles\App\Models\Role;

class ConfigWriter
{
    public function __invoke(Role $role)
    {
        $role->writeConfig();

        return ['message' => __('The config file was successfully written')];
    }
}
