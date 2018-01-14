<?php

namespace LaravelEnso\RoleManager\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use LaravelEnso\RoleManager\app\Models\Role;
use LaravelEnso\RoleManager\app\Http\Services\RolePermissionService;

class RolePermissionController extends Controller
{
    public function index(Role $role, RolePermissionService $service)
    {
        return $service->index($role);
    }

    public function update(Request $request, RolePermissionService $service)
    {
        return $service->update($request);
    }
}
