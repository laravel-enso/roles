<?php

namespace LaravelEnso\Roles\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\Forms\Builders\Role;

class Create extends Controller
{
    public function __invoke(Role $form)
    {
        return ['form' => $form->create()];
    }
}
