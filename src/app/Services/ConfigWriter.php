<?php

namespace LaravelEnso\Roles\app\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use LaravelEnso\Menus\app\Models\Menu;
use LaravelEnso\Roles\app\Enums\Roles;
use LaravelEnso\Roles\app\Exceptions\Role as Exception;
use LaravelEnso\Roles\app\Models\Role;

class ConfigWriter
{
    private $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function handle()
    {
        $this->validateRole()
            ->validateDirectory();

        $replaceArray = array_filter($this->replaceArray());

        $migration = str_replace(
            array_keys($replaceArray),
            array_values($replaceArray),
            $this->stub()
        );

        $path = config_path('local/roles/'.$this->role->name.'.php');

        File::put($path, $migration);
    }

    private function replaceArray()
    {
        return [
            '${order}' => $this->order(),
            '${name}' => $this->role->name,
            '${displayName}' => $this->role->display_name,
            '${defaultMenuRoute}' => $this->menuRoute(),
            '${permissions}' => $this->permissions(),
        ];
    }

    private function order()
    {
        return Role::whereName($this->role->name)
            ->first()
            ->id;
    }

    private function menuRoute()
    {
        return $this->role->menu_id
            ? Menu::with('permission')
                ->find($this->role->menu_id)
                ->permission
                ->name
            : null;
    }

    private function permissions()
    {
        $permissions = $this->role->permissions()
            ->pluck('name')
            ->implode("',".PHP_EOL."        '");

        return $this->format($permissions);
    }

    private function format($enumeration)
    {
        return "'".$enumeration."'";
    }

    private function validateRole()
    {
        if ($this->role->id === App::make(Roles::class)::Admin) {
            throw Exception::adminSync();
        }

        return $this;
    }

    private function validateDirectory()
    {
        if (! File::isDirectory(config_path('local/roles/'))) {
            File::makeDirectory(config_path('local/roles/'), 0755, true);
        }
    }

    private function stub()
    {
        return File::get(__DIR__.'/stubs/role.stub');
    }
}
