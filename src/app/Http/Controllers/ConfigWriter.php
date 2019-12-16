<?php

namespace LaravelEnso\Roles\app\Http\Controllers;

use LaravelEnso\Roles\app\Enums\Roles;
use LaravelEnso\Roles\app\Exceptions\Role as Exception;
use LaravelEnso\Roles\app\Models\Role;
use LaravelEnso\Roles\app\Services\ConfigWriter as Service;

class ConfigWriter
{
    public function __invoke(Role $role)
    {
        if ($role->id === Roles::Admin) {
            throw Exception::adminConfig();
        }
        (new Service($role))->handle();

        return ['message' => __('The config file was successfully written')];
    }
}
