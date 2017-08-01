<?php

namespace LaravelEnso\RoleManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\DataTable\app\Traits\DataTable;
use LaravelEnso\RoleManager\app\DataTable\RolesTableStructure;
use LaravelEnso\RoleManager\app\Models\Role;

class RoleTableController extends Controller
{
    use DataTable;

    protected $tableStructureClass = RolesTableStructure::class;

    public function getTableQuery()
    {
        return Role::select(\DB::raw('roles.id as DT_RowId, roles.name,
            roles.display_name, roles.description, roles.created_at, roles.updated_at,
            roles.menu_id')
        );
    }
}
