<?php

namespace LaravelEnso\RoleManager\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use LaravelEnso\RoleManager\app\Models\Role;
use LaravelEnso\RoleManager\app\Http\Services\RolePermissionService;

class RolePermissionController extends Controller
{
    private $service;

    public function __construct(Request $request)
    {
        $this->service = new RolePermissionService($request);
    }

    public function index(Role $role)
    {
        return $this->service->index($role);
    }

    public function update()
    {
        return $this->service->update();
    }
}
