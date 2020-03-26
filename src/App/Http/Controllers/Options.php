<?php

namespace LaravelEnso\Roles\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\App\Models\Role;
use LaravelEnso\Select\App\Traits\OptionsBuilder;

class Options extends Controller
{
    use OptionsBuilder;

    public function query()
    {
        return Role::visible();
    }
}
