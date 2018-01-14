<?php

use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\RoleManager\app\Models\Role;
use Illuminate\Database\Migrations\Migration;

class InsertDefaultRoles extends Migration
{
    public function up()
    {
        \DB::transaction(function () {
            $roles = [
                ['menu_id' => null, 'name' => 'admin', 'display_name' => 'Administrator', 'description' => 'Administrator role. Full featured.'],
                ['menu_id' => null, 'name' => 'supervisor', 'display_name' => 'Supervisor', 'description' => 'Supervisor role.'],
            ];

            $menus = Menu::pluck('id');

            foreach ($roles as $role) {
                $role = Role::create($role);
                $role->menus()->sync($menus);
            }
        });
    }

    public function down()
    {
        \DB::table('roles')->delete();
    }
}
