<?php

namespace LaravelEnso\Roles\app\Http\Controllers\Role;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\app\Forms\Builders\RoleForm;
use LaravelEnso\Roles\app\Models\Role;

class Edit extends Controller
{
    public function __invoke(Role $role, RoleForm $form)
    {
        return ['form' => $form->edit($role)];
    }
}
