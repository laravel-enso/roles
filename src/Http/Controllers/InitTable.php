<?php

namespace LaravelEnso\Roles\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\Tables\Builders\RoleTable;
use LaravelEnso\Tables\Traits\Init;

class InitTable extends Controller
{
    use Init;

    protected $tableClass = RoleTable::class;
}
