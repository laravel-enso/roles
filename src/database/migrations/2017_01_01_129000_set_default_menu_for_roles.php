<?php

use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\RoleManager\app\Models\Role;
use Illuminate\Database\Migrations\Migration;

class SetDefaultMenuForRoles extends Migration
{
    public function up()
    {
        $roles = Role::all();
        $menu = Menu::whereHasChildren(false)->first();

        \DB::transaction(function () use ($roles, $menu) {
            $roles->each(function ($role) use ($menu) {
                $role->update(['menu_id' => $menu->id]);
            });
        });
    }

    public function down()
    {
        $roles = Role::all();

        $roles->each(function ($role) {
            $role->update(['menu_id' => null]);
        });
    }
}
