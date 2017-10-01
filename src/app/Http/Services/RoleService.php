<?php

namespace LaravelEnso\RoleManager\app\Http\Services;

use Illuminate\Http\Request;
use LaravelEnso\FormBuilder\app\Classes\FormBuilder;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\PermissionManager\app\Models\Permission;
use LaravelEnso\RoleManager\app\Models\Role;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class RoleService
{
    const FormPath = __DIR__ . '/../../Forms/role.json';

    public function create()
    {
        $form = (new FormBuilder(self::FormPath))
            ->setMethod('POST')
            ->setTitle('Create Role')
            ->setSelectOptions('menu_id', Menu::isNotParent()->pluck('name', 'id'))
            ->getData();

        return compact('form');
    }

    public function store(Request $request, Role $role)
    {
        \DB::transaction(function () use ($request, &$role) {
            $role        = $role->create($request->all());
            $permissions = Permission::implicit()->pluck('id');
            $role->permissions()->attach($permissions);
            $role->menus()->attach($role->menu_id);
        });

        return [
            'message'  => __('The role was created!'),
            'redirect' => 'system.roles.edit',
            'id'       => $role->id,
        ];
    }

    public function edit(Role $role)
    {
        $form = (new FormBuilder(self::FormPath, $role))
            ->setMethod('PATCH')
            ->setTitle('Edit role')
            ->setSelectOptions('menu_id', Menu::isNotParent()->pluck('name', 'id'))
            ->getData();

        return compact('form', 'role');
    }

    public function update(Request $request, Role $role)
    {
        $role->update($request->all());
        $role->save();

        return [
            'message' => __(config('enso.labels.savedChanges')),
        ];
    }

    public function destroy(Role $role)
    {
        if ($role->users->count()) {
            throw new ConflictHttpException(__('Operation failed because the role is in use'));
        }

        $role->delete();

        return [
            'message'  => __(config('enso.labels.successfulOperation')),
            'redirect' => 'system.roles.index',
        ];
    }
}
