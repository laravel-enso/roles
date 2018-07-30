<?php

namespace LaravelEnso\RoleManager\app\Commands;

use Illuminate\Console\Command;
use LaravelEnso\PermissionManager\app\Models\Permission;
use LaravelEnso\PermissionManager\app\Models\PermissionGroup;

class AddMissingPermission extends Command
{
    protected $signature = 'enso:roles:add-missing-permission';

    protected $description = 'Add permission for menu config generation';

    public function handle()
    {
        if (Permission::whereName('system.roles.writeConfig')->first() !== null) {
            $this->info('The `system.roles.writeConfig` permission was already added');

            return;
        }

        Permission::create([
            'permission_group_id' => PermissionGroup::whereName('system.roles')
                                        ->first()->id,
            'name' => 'system.roles.writeConfig',
            'description' => 'Write role configuration file',
            'type' => 1,
            'is_default' => false,
        ]);

        $this->info('The `system.roles.writeConfig` permission was successfully added');
    }
}
