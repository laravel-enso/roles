<?php

namespace LaravelEnso\Roles\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\App\Http\Requests\ValidateRoleRequest;
use LaravelEnso\Roles\App\Models\Role;

class Update extends Controller
{
    public function __invoke(ValidateRoleRequest $request, Role $role)
    {
        $role->update($request->validated());

        return ['message' => __('The role was successfully updated')];
    }
}
