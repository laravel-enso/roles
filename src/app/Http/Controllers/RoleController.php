<?php

namespace LaravelEnso\RoleManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\RoleManager\app\Models\Role;
use LaravelEnso\RoleManager\app\Forms\Builders\RoleForm;
use LaravelEnso\RoleManager\app\Http\Requests\ValidateRoleRequest;

class RoleController extends Controller
{
    public function create(RoleForm $form)
    {
        return ['form' => $form->create()];
    }

    public function store(ValidateRoleRequest $request, Role $role)
    {
        $role = $role->storeWithPermissions($request->all());

        return [
            'message' => __('The role was created!'),
            'redirect' => 'system.roles.edit',
            'id' => $role->id,
        ];
    }

    public function edit(Role $role, RoleForm $form)
    {
        return ['form' => $form->edit($role)];
    }

    public function update(ValidateRoleRequest $request, Role $role)
    {
        $role->update($request->all());

        return [
            'message' => __(config('enso.labels.savedChanges')),
        ];
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return [
            'message' => __(config('enso.labels.successfulOperation')),
            'redirect' => 'system.roles.index',
        ];
    }
}
