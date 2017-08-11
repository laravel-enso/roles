<?php

namespace LaravelEnso\RoleManager\app\Http\Services;

use Illuminate\Http\Request;
use LaravelEnso\FormBuilder\app\Classes\FormBuilder;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\PermissionManager\app\Models\Permission;
use LaravelEnso\RoleManager\app\Models\Role;

class RoleService
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function create()
    {
        $form = (new FormBuilder(__DIR__.'/../../Forms/role.json'))
            ->setAction('POST')
            ->setTitle('Create Role')
            ->setUrl('/system/roles')
            ->setSelectOptions('menu_id', Menu::isNotParent()->pluck('name', 'id'))
            ->getData();

        return view('laravel-enso/rolemanager::create', compact('form'));
    }

    public function store(Role $role)
    {
        \DB::transaction(function () use (&$role) {
            $role = $role->create($this->request->all());
            $permissions = Permission::implicit()->pluck('id');
            $role->permissions()->attach($permissions);
            $role->menus()->attach($role->menu_id);
        });

        return [
            'message'  => __('The role was created!'),
            'redirect' => '/system/roles/'.$role->id.'/edit',
        ];
    }

    public function edit(Role $role)
    {
        $form = (new FormBuilder(__DIR__.'/../../Forms/role.json', $role))
            ->setAction('PATCH')
            ->setTitle('Edit role')
            ->setUrl('/system/roles/'.$role->id)
            ->setSelectOptions('menu_id', Menu::isNotParent()->pluck('name', 'id'))
            ->getData();

        return view('laravel-enso/rolemanager::edit', compact('form', 'role'));
    }

    public function update(Role $role)
    {
        $role->update($this->request->all());
        $role->save();

        return [
            'message' => __(config('labels.savedChanges')),
        ];
    }

    public function destroy(Role $role)
    {
        if ($role->users->count()) {
            throw new \EnsoException(__('Operation failed because the role is in use'));
        }

        $role->delete();

        return ['message' => __(config('labels.successfulOperation'))];
    }
}
