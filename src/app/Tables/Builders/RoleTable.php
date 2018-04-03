<?php

namespace LaravelEnso\RoleManager\app\Tables\Builders;

use LaravelEnso\RoleManager\app\Models\Role;
use LaravelEnso\VueDatatable\app\Classes\Table;

class RoleTable extends Table
{
    protected $templatePath = __DIR__.'/../Templates/roles.json';

    public function query()
    {
        return Role::select(\DB::raw(
            'roles.id as "dtRowId", roles.name, roles.display_name, roles.description,
            roles.created_at, roles.updated_at, roles.menu_id'
        ));
    }
}
