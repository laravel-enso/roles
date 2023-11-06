<?php

namespace LaravelEnso\Roles\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\Http\Requests\ValidateRole;
use LaravelEnso\Roles\Models\Role;

class Store extends Controller
{
    public function __invoke(ValidateRole $request, Role $role)
    {
        $role->fill($request->safe()->except('userGroups'))->save();
        $role->addDefaultPermissions();
        $role->userGroups()->sync($request->get('userGroups'));

        return [
            'message' => __('The role was created!'),
            'redirect' => 'system.roles.edit',
            'param' => ['role' => $role->id],
        ];
    }
}
