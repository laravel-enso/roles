<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use LaravelEnso\Permissions\App\Models\Permission;
use LaravelEnso\Roles\App\Models\Role;

class RoleSeeder extends Seeder
{
    private const Roles = [
        ['menu_id' => 1, 'name' => 'admin', 'display_name' => 'Administrator', 'description' => 'Administrator role. Full featured.'],
        ['menu_id' => 1, 'name' => 'supervisor', 'display_name' => 'Supervisor', 'description' => 'Supervisor role.'],
        ['menu_id' => null, 'name' => 'api', 'display_name' => 'Api', 'description' => 'Api role.'],
    ];

    public function run()
    {
        $roles = (new Collection(self::Roles))
            ->map(fn ($role) => factory(Role::class)->create($role));

        $admin = $roles->where('name', 'admin')->first();

        $admin->permissions()->sync(Permission::pluck('id'));

        $api = $roles->where('name', 'api')->first();

        $api->permissions()->sync(Permission::controlPanel()->pluck('id'));

        $supervisor = $roles->where('name', 'supervisor')->first();

        $supervisor->permissions()->sync(Permission::implicit()->pluck('id'));
    }
}
