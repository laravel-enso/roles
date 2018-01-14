<?php

namespace LaravelEnso\RoleManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\RoleManager\app\Models\Role;
use LaravelEnso\RoleManager\app\Http\Services\RoleService;
use LaravelEnso\RoleManager\app\Http\Requests\ValidateRoleRequest;

class RoleController extends Controller
{
    public function create(RoleService $service)
    {
        return $service->create();
    }

    public function store(ValidateRoleRequest $request, Role $role, RoleService $service)
    {
        return $service->store($request, $role);
    }

    public function edit(Role $role, RoleService $service)
    {
        return $service->edit($role);
    }

    public function update(ValidateRoleRequest $request, Role $role, RoleService $service)
    {
        return $service->update($request, $role);
    }

    public function destroy(Role $role, RoleService $service)
    {
        return $service->destroy($role);
    }
}
