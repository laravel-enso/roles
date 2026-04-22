<?php

namespace LaravelEnso\Roles\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use LaravelEnso\Menus\Models\Menu;
use LaravelEnso\Permissions\Models\Permission;
use LaravelEnso\Roles\Models\Role;

class Sync
{
    public function handle(): void
    {
        Collection::wrap(File::files($this->directory()))
            ->map(fn ($file) => require $file->getRealPath())
            ->sortBy('order')
            ->each(fn ($config) => $this->sync($config));
    }

    private function sync(array $config): void
    {
        Role::updateOrCreate([
            'name' => $config['role']['name'],
        ], [
            'display_name' => $config['role']['display_name'],
            'menu_id'      => $this->menu($config)?->id,
        ])->syncPermissions($this->permissionIds($config));
    }

    private function menu($config): ?Menu
    {
        if (!$config['default_menu']) {
            return null;
        }

        return Menu::query()
            ->whereHas('permission', fn ($permission) => $permission
                ->whereName($config['default_menu']))->first();
    }

    private function permissionIds($config): array
    {
        return Permission::whereIn('name', $config['permissions'])
            ->pluck('id')->toArray();
    }

    private function directory(): string
    {
        return Config::get('enso.roles.configPath', config_path('local/roles'));
    }
}
