<?php

namespace LaravelEnso\Roles\app\Http\Controllers\Configure;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\app\Models\Role;
use LaravelEnso\Roles\app\Http\Responses\RoleConfigurator;

class Index extends Controller
{
    public function __invoke(Role $role)
    {
        return new RoleConfigurator($role);
    }
}
