<?php

namespace LaravelEnso\Roles\app\Http\Controllers\Role;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\app\Tables\Builders\RoleTable;
use LaravelEnso\Tables\app\Traits\Excel;

class ExportExcel extends Controller
{
    use Excel;

    protected $tableClass = RoleTable::class;
}
