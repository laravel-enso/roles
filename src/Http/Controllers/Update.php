<?php

namespace LaravelEnso\Roles\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\Http\Requests\ValidateRole;
use LaravelEnso\Roles\Models\Role;

class Update extends Controller
{
    public function __invoke(ValidateRole $request, Role $role)
    {
        $role->update($request->validated());

        return ['message' => __('The role was successfully updated')];
    }
}
