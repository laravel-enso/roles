<?php

namespace LaravelEnso\Roles\App\Http\Controllers\Configure;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\App\Http\Responses\RoleConfigurator;
use LaravelEnso\Roles\App\Models\Role;

class Index extends Controller
{
    public function __invoke(Role $role)
    {
        return new RoleConfigurator($role);
    }
}
