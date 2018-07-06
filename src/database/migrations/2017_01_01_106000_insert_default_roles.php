<?php

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

            collect($roles)->each(function ($role) {
                Role::create($role);
            });
        });
    }

    public function down()
    {
        \DB::table('roles')->delete();
    }
}
