<?php

namespace LaravelEnso\RoleManager\app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelEnso\RoleManager\app\Models\Role;
use LaravelEnso\RoleManager\app\Http\Responses\RoleConfigurator;

class RoleConfiguratorController extends Controller
{
    public function index(Role $role)
    {
        return new RoleConfigurator($role);
    }

    public function update(Request $request, Role $role)
    {
        $role->syncPermissions(
            $request->get('rolePermissions')
        );

        return [
            'message' => __("The role's permissions were successfully updated"),
        ];
    }
}
