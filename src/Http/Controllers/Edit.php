<?php

namespace LaravelEnso\Roles\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\Forms\Builders\RoleForm;
use LaravelEnso\Roles\Models\Role;

class Edit extends Controller
{
    public function __invoke(Role $role, RoleForm $form)
    {
        return ['form' => $form->edit($role)];
    }
}
