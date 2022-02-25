<?php

namespace LaravelEnso\Roles\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\Forms\Builders\Role;
use LaravelEnso\Roles\Models\Role as Model;

class Edit extends Controller
{
    public function __invoke(Model $role, Role $form)
    {
        return ['form' => $form->edit($role)];
    }
}
