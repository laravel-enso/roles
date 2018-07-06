<?php

namespace LaravelEnso\RoleManager\app\Http\Controllers;

use LaravelEnso\RoleManager\app\Models\Role;
use LaravelEnso\RoleManager\app\Classes\ConfigWriter;

class ConfigWriterController
{
    public function __invoke(Role $role)
    {
        (new ConfigWriter($role))->run();

        return [
            'message' => 'The config file was successfully written',
        ];
    }
}
