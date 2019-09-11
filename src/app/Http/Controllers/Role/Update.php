<?php

namespace LaravelEnso\Roles\app\Http\Controllers\Role;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\app\Models\Role;
use LaravelEnso\Roles\app\Http\Requests\ValidateRoleUpdate;

class Update extends Controller
{
    public function __invoke(ValidateRoleUpdate $request, Role $role)
    {
        $role->update($request->validated());

        return ['message' => __('The role was successfully updated')];
    }
}
