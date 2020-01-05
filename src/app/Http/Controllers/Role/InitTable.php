<?php

namespace LaravelEnso\Roles\App\Http\Controllers\Role;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\App\Tables\Builders\RoleTable;
use LaravelEnso\Tables\App\Traits\Init;

class InitTable extends Controller
{
    use Init;

    protected $tableClass = RoleTable::class;
}
