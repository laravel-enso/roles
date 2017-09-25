<?php

namespace LaravelEnso\RoleManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelEnso\RoleManager\app\Http\Requests\ValidateRoleRequest;
use LaravelEnso\RoleManager\app\Http\Services\RoleService;
use LaravelEnso\RoleManager\app\Models\Role;

class RoleController extends Controller
{
    private $service;

    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }

    public function create()
    {
        return $this->service->create();
    }

    public function store(ValidateRoleRequest $request, Role $role)
    {
        return $this->service->store($request, $role);
    }

    public function edit(Role $role)
    {
        return $this->service->edit($role);
    }

    public function update(ValidateRoleRequest $request, Role $role)
    {
        return $this->service->update($request, $role);
    }

    public function destroy(Role $role)
    {
        return $this->service->destroy($role);
    }
}
