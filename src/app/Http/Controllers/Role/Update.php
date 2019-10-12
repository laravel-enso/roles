<?php

namespace LaravelEnso\Roles\app\Http\Controllers\Role;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\app\Models\Role;
use LaravelEnso\Roles\app\Http\Requests\ValidateRoleRequest;

class Update extends Controller
{
    public function __invoke(ValidateRoleRequest $request, Role $role)
    {
        $role->update($request->validated());

        return ['message' => __('The role was successfully updated')];
    }
}
