<?php

namespace LaravelEnso\RoleManager\app\Handlers;

use LaravelEnso\Helpers\app\Classes\Obj;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\RoleManager\app\Models\Role;
use LaravelEnso\PermissionManager\app\Models\PermissionGroup;

class RoleConfiguratorResource
{
    private $role;

    public function __construct(Role $role)
    {
        $this->role = $role->load(['menus', 'permissions']);
    }

    public function get()
    {
        return [
            'menus' => Menu::orderBy('name')->get(),
            'roleMenus' => $this->role->menus->pluck('id'),
            'rolePermissions' => $this->role->permissions->pluck('id'),
            'permissions' => $this->permissions(),
            'role' => $this->role,
        ];
    }

    private function groups()
    {
        return PermissionGroup::with([
            'permissions' => function ($query) {
                $query->orderBy('name');
            },
        ])->get();
    }

    private function permissions()
    {
        return $this->groups()->reduce(function ($collection, $group) {
            $this->fill($collection, $group);

            return $collection;
        }, new Obj());
    }

    private function fill($collection, $group)
    {
        $labels = collect(explode('.', $group->name));
        $count = $labels->count();
        $obj = $collection;

        $labels->each(function ($label, $index) use (&$obj, $group, $count) {
            if (!property_exists($obj, $label)) {
                $obj->$label = $index + 1 < $count
                    ? new Obj()
                    : $group->permissions;
            }

            $obj = $obj->$label;
        });
    }
}
