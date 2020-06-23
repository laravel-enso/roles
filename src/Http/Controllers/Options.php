<?php

namespace LaravelEnso\Roles\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\Models\Role;
use LaravelEnso\Select\Traits\OptionsBuilder;

class Options extends Controller
{
    use OptionsBuilder;

    public function query()
    {
        return Role::visible();
    }
}
