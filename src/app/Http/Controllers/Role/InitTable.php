<?php

namespace LaravelEnso\Roles\app\Http\Controllers\Role;

use Illuminate\Routing\Controller;
use LaravelEnso\Tables\app\Traits\Init;
use LaravelEnso\Roles\app\Tables\Builders\RoleTable;

class InitTable extends Controller
{
    use Init;

    protected $tableClass = RoleTable::class;
}
