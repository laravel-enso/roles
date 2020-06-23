<?php

namespace LaravelEnso\Roles\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\Forms\Builders\RoleForm;

class Create extends Controller
{
    public function __invoke(RoleForm $form)
    {
        return ['form' => $form->create()];
    }
}
