<?php

namespace LaravelEnso\Roles\app\Http\Controllers\Role;

use Illuminate\Routing\Controller;
use LaravelEnso\Tables\app\Traits\Excel;
use LaravelEnso\Roles\app\Tables\Builders\RoleTable;

class ExportExcel extends Controller
{
    use Excel;

    protected $tableClass = RoleTable::class;
}
