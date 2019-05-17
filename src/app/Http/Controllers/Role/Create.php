<?php

namespace LaravelEnso\Roles\app\Http\Controllers\Role;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\app\Forms\Builders\RoleForm;

class Create extends Controller
{
    public function __invoke(RoleForm $form)
    {
        return ['form' => $form->create()];
    }
}
