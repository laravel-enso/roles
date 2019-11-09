<?php

namespace LaravelEnso\Roles\app\Http\Controllers\Role;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\app\Http\Requests\ValidateRoleRequest;
use LaravelEnso\Roles\app\Models\Role;

class Store extends Controller
{
    public function __invoke(ValidateRoleRequest $request, Role $role)
    {
        tap($role)->fill($request->validated())
            ->save();

        $role->addDefaultPermissions();

        return [
            'message' => __('The role was created!'),
            'redirect' => 'system.roles.edit',
            'param' => ['role' => $role->id],
        ];
    }
}
