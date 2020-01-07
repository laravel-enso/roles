<?php

namespace LaravelEnso\Roles\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\App\Forms\Builders\RoleForm;
use LaravelEnso\Roles\App\Models\Role;

class Edit extends Controller
{
    public function __invoke(Role $role, RoleForm $form)
    {
        return ['form' => $form->edit($role)];
    }
}
