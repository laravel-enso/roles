<?php

namespace LaravelEnso\RoleManager\app\Http\Services;

use Illuminate\Http\Request;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\PermissionManager\app\Classes\GroupPermissionStructure;
use LaravelEnso\PermissionManager\app\Models\PermissionGroup;
use LaravelEnso\RoleManager\app\Models\Role;

class RolePermissionService
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getPermissions(Role $role)
    {
        $groups = PermissionGroup::with([
            'permissions' => function ($query) {
                $query->orderBy('name');
            },
        ])->get();

        $permissions = (new GroupPermissionStructure($groups))->get();

        return [
            'menus'           => Menu::orderBy('name')->get(),
            'roleMenus'       => $role->menus->pluck('id'),
            'rolePermissions' => $role->permissions->pluck('id'),
            'permissions'     => $permissions,
        ];
    }

    public function setPermissions()
    {
        \DB::transaction(function () {
            $role = Role::find(request()->role_id);
            $role->menus()->sync(request()->roleMenus);
            $role->permissions()->sync(request()->rolePermissions);
        });

        return ['message' => __('Operation was successfull')];
    }
}
