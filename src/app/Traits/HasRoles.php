<?php

namespace LaravelEnso\Roles\App\Traits;

use LaravelEnso\Roles\App\Models\Role;

trait HasRoles
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function updateWithRoles(array $attributes)
    {
        tap($this)->update($attributes)
            ->roles()->sync($attributes['roles']);
    }

    public function storeWithRoles(array $attributes)
    {
        $this->fill($attributes);

        tap($this)->save()
            ->roles()->sync($attributes['roles']);

        return $this;
    }
}
