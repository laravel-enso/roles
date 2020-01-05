<?php

namespace LaravelEnso\Roles\App\Http\Controllers;

use LaravelEnso\Roles\App\Models\Role;
use LaravelEnso\Roles\App\Services\ConfigWriter as Service;

class ConfigWriter
{
    public function __invoke(Role $role)
    {
        (new Service($role))->handle();

        return ['message' => __('The config file was successfully written')];
    }
}
