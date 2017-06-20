<?php

namespace LaravelEnso\RoleManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelEnso\RoleManager\app\Http\Services\RolePermissionService;
use LaravelEnso\RoleManager\app\Models\Role;

class RolePermissionController extends Controller
{
    private $service;

    public function __construct(Request $request)
    {
        $this->service = new RolePermissionService($request);
    }

    public function getPermissions(Role $role)
    {
        return $this->service->getPermissions($role);
    }

    public function setPermissions()
    {
        return $this->service->setPermissions();
    }
}
