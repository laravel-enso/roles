<?php

namespace LaravelEnso\RoleManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\RoleManager\app\Models\Role;
use LaravelEnso\Select\app\Traits\SelectListBuilder;

class RoleSelectController extends Controller
{
    use SelectListBuilder;

    protected $selectSourceClass = Role::class;
}
