<?php

namespace LaravelEnso\RoleManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\RoleManager\app\Models\Role;
use LaravelEnso\VueDatatable\app\Traits\Excel;
use LaravelEnso\VueDatatable\app\Traits\Datatable;

class RoleTableController extends Controller
{
    use Datatable, Excel;

    private const Template = __DIR__.'/../../Tables/roles.json';

    public function query()
    {
        return Role::select(\DB::raw(
            'roles.id as dtRowId, roles.name, roles.display_name, roles.description,
            roles.created_at, roles.updated_at, roles.menu_id'
        ));
    }
}
