<?php

namespace LaravelEnso\RoleManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\PermissionManager\app\Models\PermissionGroup;
use LaravelEnso\RoleManager\app\Models\Role;

class RolePermissionController extends Controller
{
    public function getPermissions(Role $role)
    {
        $menus = Menu::all();
        $permissionsGroups = PermissionGroup::with('permissions')->get();
        $roleMenus = $role->menus->pluck('id');
        $rolePermissions = $role->permissions->pluck('id');
        $permissions = $this->buildPermissionGroupsStructure($permissionsGroups);

        return [
            'menus' => $menus,
            'roleMenus' => $roleMenus,
            'rolePermissions' => $rolePermissions,
            'permissions' => $permissions,
        ];
    }

    public function setPermissions()
    {
        \DB::transaction(function () {
            $role = Role::find(request()->role_id);
            $role->menus()->sync(request()->roleMenus);
            $role->permissions()->sync(request()->rolePermissions);
        });

        return [
            'level' => 'success',
            'message' => __('Operation was successfull'),
        ];
    }

    private function buildPermissionGroupsStructure($permissionsGroups, $label = null)
    {
        $structure = [];
        $labels = [];

        foreach ($permissionsGroups as $permissionsGroup) {
            if (!$label || strpos($permissionsGroup->name, $label) === 0) {
                if ($permissionsGroup->name == $label) {
                    return $permissionsGroup->permissions;
                }

                $remainingLabels = $label ? substr($permissionsGroup->name, strlen($label) + 1) : $permissionsGroup->name;
                $labelsArray = explode('.', $remainingLabels);
                $labels[] = $labelsArray[0];
            }
        }

        $labels = array_unique($labels);

        foreach ($labels as $currentLabel) {
            $structure[$currentLabel] = $this->buildPermissionGroupsStructure($permissionsGroups, $label ? $label . '.' . $currentLabel : $currentLabel);
        }

        return $structure;
    }
}
