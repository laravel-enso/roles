<?php

namespace LaravelEnso\Roles\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use LaravelEnso\Menus\Models\Menu;
use LaravelEnso\Permissions\Models\Permission;
use LaravelEnso\Roles\Models\Role;
use Symfony\Component\Finder\SplFileInfo;

class Sync
{
    public function handle(): void
    {
        (new Collection(File::files(config_path('local/roles'))))
            ->map(fn ($file) => config("local.roles.{$this->role($file)}"))
            ->sortBy('order')//TODO Why do we need this?!
            ->each(fn ($config) => $this->sync($config));
    }

    private function sync(array $config): void
    {
        Role::updateOrCreate([
            'name' => $config['role']['name'],
        ], [
            'display_name' => $config['role']['display_name'],
            'menu_id' => optional($this->menu($config))->id,
        ])->permissions()->sync($this->permissionIds($config));
    }

    private function menu($config): ?Menu
    {
        $permission = Permission::whereName($config['default_menu'])->first();

        return $permission
            ? Menu::wherePermissionId($permission->id)->first()
            : null;
    }

    private function permissionIds($config): Collection
    {
        return Permission::whereIn('name', $config['permissions'])->pluck('id');
    }

    private function role(SplFileInfo $file): string
    {
        return str_replace('.php', '', $file->getFilename());
    }
}
