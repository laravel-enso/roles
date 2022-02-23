<?php

namespace LaravelEnso\Roles\Tables\Builders;

use Illuminate\Database\Eloquent\Builder;
use LaravelEnso\Roles\Models\Role as Model;
use LaravelEnso\Tables\Contracts\Table;

class Role implements Table
{
    private const TemplatPath = __DIR__.'/../Templates/roles.json';

    public function query(): Builder
    {
        return Model::selectRaw('
            roles.id, roles.name, roles.display_name, roles.description,
            roles.created_at, menus.name as menu
        ')->leftJoin('menus', 'roles.menu_id', '=', 'menus.id');
    }

    public function templatePath(): string
    {
        return static::TemplatPath;
    }
}
