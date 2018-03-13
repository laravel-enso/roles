<?php

namespace LaravelEnso\RoleManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\RoleManager\app\Models\Role;
use LaravelEnso\Select\app\Traits\OptionsBuilder;

class RoleSelectController extends Controller
{
    use OptionsBuilder;

    protected $model = Role::class;
}
