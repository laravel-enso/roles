<?php

namespace LaravelEnso\Roles\App\Http\Controllers\Role;

use Illuminate\Routing\Controller;
use LaravelEnso\Roles\App\Models\Role;

class Destroy extends Controller
{
    public function __invoke(Role $role)
    {
        $role->delete();

        return [
            'message' => __('The role was successfully deleted'),
            'redirect' => 'system.roles.index',
        ];
    }
}
