<?php

namespace LaravelEnso\Roles\App\Tables\Builders;

use Illuminate\Database\Eloquent\Builder;
use LaravelEnso\Roles\App\Models\Role;
use LaravelEnso\Tables\App\Contracts\Table;

class RoleTable implements Table
{
    protected const TemplatPath = __DIR__.'/../Templates/roles.json';

    public function query(): Builder
    {
        return Role::selectRaw('
            roles.id, roles.name, roles.display_name, roles.description,
            roles.created_at, menus.name as defaultMenu
        ')->leftJoin('menus', 'roles.menu_id', '=', 'menus.id');
    }

    public function templatePath(): string
    {
        return static::TemplatPath;
    }
}
