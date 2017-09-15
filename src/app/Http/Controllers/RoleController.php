<?php

namespace LaravelEnso\RoleManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelEnso\RoleManager\app\Http\Requests\ValidateRoleRequest;
use LaravelEnso\RoleManager\app\Http\Services\RoleService;
use LaravelEnso\RoleManager\app\Models\Role;

class RoleController extends Controller
{
    private $roles;

    public function __construct(Request $request)
    {
        $this->roles = new RoleService($request);
    }

    public function index()
    {
        return view('laravel-enso/rolemanager::index');
    }

    public function create()
    {
        return $this->roles->create();
    }

    public function store(ValidateRoleRequest $request, Role $role)
    {
        return $this->roles->store($role);
    }

    public function edit(Role $role)
    {
        return $this->roles->edit($role);
    }

    public function update(ValidateRoleRequest $request, Role $role)
    {
        return $this->roles->update($role);
    }

    public function destroy(Role $role)
    {
        return $this->roles->destroy($role);
    }
}
