<?php

namespace LaravelEnso\Roles\app\Http\Controllers\Role;

use Illuminate\Routing\Controller;
use LaravelEnso\Tables\app\Traits\Excel;
use LaravelEnso\Tables\app\Traits\Datatable;
use LaravelEnso\Roles\app\Tables\Builders\RoleTable;

class Table extends Controller
{
    use Datatable, Excel;

    protected $tableClass = RoleTable::class;
}
