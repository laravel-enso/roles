<?php

namespace LaravelEnso\RoleManager\app\Http\Responses;

use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\RoleManager\app\Models\Role;
use Illuminate\Contracts\Support\Responsable;
use LaravelEnso\RoleManager\app\Classes\PermissionTree;

class RoleConfigurator implements Responsable
{
    private $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function toResponse($request)
    {
        return [
            'permissions' => (new PermissionTree())->get(),
            'role' => $this->role,
            'rolePermissions' => $this->rolePermissions(),
        ];
    }

    private function menus()
    {
        return Menu::orderBy('name')
            ->get(['id', 'name']);
    }

    public function roleMenus()
    {
        return $this->role
            ->menus()
            ->pluck('id');
    }

    public function rolePermissions()
    {
        return $this->role
            ->permissions()
            ->pluck('id');
    }
}
