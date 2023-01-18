<?php

namespace LaravelEnso\Roles\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use LaravelEnso\Roles\Exceptions\Role as Exception;
use LaravelEnso\Roles\Models\Role;

class ConfigWriter
{
    public function __construct(private Role $role)
    {
    }

    public function handle(): void
    {
        $this->validateRole()
            ->validateDirectory()
            ->write();
    }

    private function validateRole(): self
    {
        if ($this->role->isAdmin()) {
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
            '${order}' => $this->order(),
            '${name}' => $this->role->name,
            '${displayName}' => $this->role->display_name,
            '${defaultMenuRoute}' => $this->role->menu?->permission->name,
            '${permissions}' => $this->permissions(),
        ];
    }

    private function order(): int
    {
        return Role::whereName($this->role->name)->first()->id;
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
