<?php

namespace LaravelEnso\Roles\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use LaravelEnso\Menus\Models\Menu;
use LaravelEnso\Roles\Enums\Roles;
use LaravelEnso\Roles\Exceptions\Role as Exception;
use LaravelEnso\Roles\Models\Role;

class ConfigWriter
{
    private Role $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function handle(): void
    {
        $this->validateRole()
            ->validateDirectory()
            ->write();
    }

    private function validateRole(): self
    {
        if ($this->role->id === App::make(Roles::class)::Admin) {
            throw Exception::adminRole();
        }

        return $this;
    }

    private function validateDirectory(): self
    {
        if (! File::isDirectory(config_path('local/roles/'))) {
            File::makeDirectory(config_path('local/roles/'), 0755, true);
        }

        return $this;
    }

    private function write(): void
    {
        File::put($this->filePath(), $this->content());
    }

    private function content()
    {
        $fromTo = $this->fromTo();
        [$from, $to] = [array_keys($fromTo), array_values($fromTo)];

        return Str::of($this->stub())->replace($from, $to);
    }

    private function fromTo()
    {
        return [
            '${name}' => $this->role->name,
            '${displayName}' => $this->role->display_name,
            '${defaultMenuRoute}' => $this->menuRoute(),
            '${permissions}' => $this->permissions(),
        ];
    }

    private function menuRoute(): ?string
    {
        return $this->role->menu_id
            ? Menu::with('permission')
            ->find($this->role->menu_id)->permission->name
            : null;
    }

    private function permissions(): string
    {
        $permissions = $this->role->permissions()
            ->pluck('name')
            ->implode("',".PHP_EOL."        '");

        return "'{$permissions}'";
    }

    private function filePath(): string
    {
        return config_path("local/roles/{$this->role->name}.php");
    }

    private function stub(): string
    {
        return File::get(__DIR__.'/stubs/role.stub');
    }
}
