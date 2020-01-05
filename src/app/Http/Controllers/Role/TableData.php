<?php

namespace LaravelEnso\Roles\App\Http\Controllers\Role;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\App\Tables\Builders\RoleTable;
use LaravelEnso\Tables\App\Traits\Data;

class TableData extends Controller
{
    use Data;

    protected $tableClass = RoleTable::class;
}
