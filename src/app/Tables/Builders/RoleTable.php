<?php

namespace LaravelEnso\Roles\app\Tables\Builders;

use LaravelEnso\Roles\app\Models\Role;
use LaravelEnso\Tables\app\Services\Table;

class RoleTable extends Table
{
    protected $templatePath = __DIR__.'/../Templates/roles.json';

    public function query()
    {
        return Role::selectRaw('
            roles.id, roles.name, roles.display_name, roles.description,
            roles.created_at, menus.name as defaultMenu
        ')->join('menus', 'roles.menu_id', '=', 'menus.id');
    }
}
