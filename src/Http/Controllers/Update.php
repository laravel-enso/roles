<?php

namespace LaravelEnso\Roles\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\Http\Requests\ValidateRoleRequest;
use LaravelEnso\Roles\Models\Role;

class Update extends Controller
{
    public function __invoke(ValidateRoleRequest $request, Role $role)
    {
        $role->update($request->validated());

        return ['message' => __('The role was successfully updated')];
    }
}
