<?php

namespace LaravelEnso\RoleManager\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\VueDatatable\app\Traits\Excel;
use LaravelEnso\VueDatatable\app\Traits\Datatable;
use LaravelEnso\RoleManager\app\Tables\Builders\RoleTable;

class RoleTableController extends Controller
{
    use Datatable, Excel;

    protected $tableClass = RoleTable::class;
}
