<?php

namespace LaravelEnso\Roles\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use LaravelEnso\Menus\Models\Menu;
use LaravelEnso\Permissions\Models\Permission;
use LaravelEnso\Roles\Models\Role;
use Symfony\Component\Finder\SplFileInfo;

class Sync
{
    public function handle(): void
    {
        (new Collection(File::files(config_path('local/roles'))))
            ->map(fn ($file) => Config::get("local.roles.{$this->role($file)}"))
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
        if ($config['default_menu']) {
            $permission = Permission::whereName($config['default_menu'])->first();

            return Menu::wherePermissionId($permission->id)->first();
        }

        return  null;
    }

    private function permissionIds($config): Collection
    {
        return Permission::whereIn('name', $config['permissions'])->pluck('id');
    }

    private function role(SplFileInfo $file): string
    {
        return Str::of($file->getFilename())->replace('.php', '');
    }
}
