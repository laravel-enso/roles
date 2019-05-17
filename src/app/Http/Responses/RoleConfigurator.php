<?php

namespace LaravelEnso\Roles\app\Http\Responses;

use LaravelEnso\Roles\app\Models\Role;
use Illuminate\Contracts\Support\Responsable;
use LaravelEnso\Roles\app\Services\PermissionTree;

class RoleConfigurator implements Responsable
{
    private $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function toResponse($request)
    {
        return [
            'permissions' => (new PermissionTree())->get(),
            'role' => $this->role,
            'rolePermissions' => $this->rolePermissions(),
        ];
    }

    public function rolePermissions()
    {
        return $this->role
            ->permissions()
            ->pluck('id');
    }
}
