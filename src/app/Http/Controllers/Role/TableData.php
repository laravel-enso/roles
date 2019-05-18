<?php

namespace LaravelEnso\Roles\app\Http\Controllers\Role;

use Illuminate\Routing\Controller;
use LaravelEnso\Tables\app\Traits\Data;
use LaravelEnso\Roles\app\Tables\Builders\RoleTable;

class TableData extends Controller
{
    use Data;

    protected $tableClass = RoleTable::class;
}
