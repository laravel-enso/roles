<?php

namespace LaravelEnso\Roles\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\App\Http\Requests\ValidateRoleRequest;
use LaravelEnso\Roles\App\Models\Role;

class Store extends Controller
{
    public function __invoke(ValidateRoleRequest $request, Role $role)
    {
        $role->fill($request->validated())->save();
        $role->addDefaultPermissions();

        return [
            'message' => __('The role was created!'),
            'redirect' => 'system.roles.edit',
            'param' => ['role' => $role->id],
        ];
    }
}
