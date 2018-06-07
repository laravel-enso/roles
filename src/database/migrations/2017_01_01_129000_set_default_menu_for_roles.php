<?php

use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\RoleManager\app\Models\Role;
use Illuminate\Database\Migrations\Migration;

class SetDefaultMenuForRoles extends Migration
{
    public function up()
    {
        \DB::transaction(function () {
            $menu = Menu::whereHasChildren(false)
                ->first();

            Role::all()->each(function ($role) use ($menu) {
                $role->update(['menu_id' => $menu->id]);
            });
        });
    }

    public function down()
    {
        Role::all()->each(function ($role) {
            $role->update(['menu_id' => null]);
        });
    }
}
