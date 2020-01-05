<?php

namespace LaravelEnso\Roles\App\Http\Controllers\Role;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\App\Forms\Builders\RoleForm;

class Create extends Controller
{
    public function __invoke(RoleForm $form)
    {
        return ['form' => $form->create()];
    }
}
