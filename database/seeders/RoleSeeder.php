<?php

namespace LaravelEnso\Roles\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use LaravelEnso\Menus\Models\Menu;
use LaravelEnso\Permissions\Models\Permission;
use LaravelEnso\Roles\Models\Role;

class RoleSeeder extends Seeder
{
    private const Roles = [
        ['name' => 'admin', 'display_name' => 'Administrator', 'description' => 'Administrator role. Full featured.'],
        ['name' => 'supervisor', 'display_name' => 'Supervisor', 'description' => 'Supervisor role.'],
    ];

    public function run()
    {
        $menu = Menu::firstWhere('name', 'Dashboard');

        $roles = (new Collection(self::Roles))
            ->map(fn ($role) => Role::factory()
                ->create($role + ['menu_id' => $menu->id]));

        $admin = $roles->first();

        $admin->permissions()->sync(Permission::pluck('id'));

        $supervisor = $roles->last();

        $supervisor->permissions()->sync(Permission::implicit()->pluck('id'));
    }
}
