<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\RoleManager\app\Models\Role;

class InsertDefaultRoles extends Migration
{
    public function up()
    {
        \DB::transaction(function () {
            $roles = [
                ['menu_id' => null, 'name' => 'admin', 'display_name' => 'Administrator', 'description' => 'Administrator role. Full featured.'],
                ['menu_id' => null, 'name' => 'supervisor', 'display_name' => 'Supervisor', 'description' => 'Supervisor role. Full featured.'],
            ];

            foreach ($roles as $role) {
                $role = new Role($role);
                $role->save();
            }
        });
    }

    public function down()
    {
        \DB::table('roles')->delete();
    }
}
