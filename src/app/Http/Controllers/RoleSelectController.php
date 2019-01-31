<?php

namespace LaravelEnso\RoleManager\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\RoleManager\app\Models\Role;
use LaravelEnso\Select\app\Traits\OptionsBuilder;

class RoleSelectController extends Controller
{
    use OptionsBuilder;

    public function query()
    {
        return Role::visible();
    }
}
