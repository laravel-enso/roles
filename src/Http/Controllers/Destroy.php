<?php

namespace LaravelEnso\Roles\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\Models\Role;

class Destroy extends Controller
{
    public function __invoke(Role $role)
    {
        $role->delete();

        return [
            'message' => __('The role was successfully deleted'),
            'redirect' => 'system.roles.index',
        ];
    }
}
