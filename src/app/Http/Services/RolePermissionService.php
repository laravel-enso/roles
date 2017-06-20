<?php

namespace LaravelEnso\RoleManager\app\Http\Services;

use Illuminate\Http\Request;
use LaravelEnso\MenuManager\app\Models\Menu;
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
        $menus = Menu::all();
        $groups = PermissionGroup::with('permissions')->get();
        $roleMenus = $role->menus->pluck('id');
        $rolePermissions = $role->permissions->pluck('id');
        $permissions = $this->buildGroupsStructure($groups);

        return [
            'menus'           => $menus,
            'roleMenus'       => $roleMenus,
            'rolePermissions' => $rolePermissions,
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

    private function buildGroupsStructure($groups, $label = null)
    {
        $permissions = [];
        $labels = [];

        foreach ($groups as $group) {
            if (!$label || strpos($group->name, $label) === 0) {
                if ($group->name == $label) {
                    return $group->permissions;
                }

                $remainingLabels = $label ? substr($group->name, strlen($label) + 1) : $group->name;
                $labelsArray = explode('.', $remainingLabels);
                $labels[] = $labelsArray[0];
            }
        }

        $labels = array_unique($labels);

        foreach ($labels as $currentLabel) {
            $permissions[$currentLabel] = $this->buildGroupsStructure($groups, $label ? $label.'.'.$currentLabel : $currentLabel);
        }

        return $permissions;
    }
}
