<?php

namespace LaravelEnso\Roles\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\App\Forms\Builders\RoleForm;

class Create extends Controller
{
    public function __invoke(RoleForm $form)
    {
        return ['form' => $form->create()];
    }
}
