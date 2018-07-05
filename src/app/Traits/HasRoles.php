<?php

namespace LaravelEnso\RoleManager\app\Traits;

use LaravelEnso\RoleManager\app\Models\Role;

trait HasRoles
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function getRoleListAttribute()
    {
        return $this->roles()
            ->pluck('id');
    }

    public function updateWithRoles(array $attributes)
    {
        tap($this)->update($attributes)
            ->roles()
            ->sync($attributes['roleList']);
    }

    public function storeWithRoles(array $attributes)
    {
        $this->fill($attributes);

        tap($this)->save()
            ->roles()
            ->sync($attributes['roleList']);

        return $this;
    }
}
