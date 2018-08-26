<?php

namespace LaravelEnso\RoleManager\app\Commands;

use Illuminate\Console\Command;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\RoleManager\app\Models\Role;
use LaravelEnso\PermissionManager\app\Models\Permission;

class Sync extends Command
{
    protected $signature = 'enso:roles:sync';

    protected $description = 'Sync roles between dev and live environments';

    public function handle()
    {
        collect(\File::files(config_path('local/roles')))
            ->map(function ($file) {
                $config = str_replace('.php', '', $file->getFilename());

                return config('local.roles.'.$config);
            })->sortBy('order')
            ->each(function ($config) {
                $this->create($config);
            });

        $this->info('Roles were successfully synced');
    }

    private function create(array $config)
    {
        $role = Role::firstOrCreate(
            ['name' => $config['role']['name']],
            [
                'display_name' => $config['role']['display_name'],
                'menu_id' => $this->menuId($config),
            ]
        );

        $role->permissions()
            ->sync($this->permissionIds($config));

        $role->menus()
            ->sync($this->menuIds($config));
    }

    private function menuId($config)
    {
        return optional(Menu::whereLink($config['default_menu'])->first())
            ->id;
    }

    private function permissionIds($config)
    {
        return Permission::whereIn('name', $config['permissions'])
                ->pluck('id');
    }

    private function menuIds($config)
    {
        return Menu::whereIn('name', $config['menus'])
                ->pluck('id');
    }
}
