<?php

namespace LaravelEnso\Roles\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use LaravelEnso\Core\Models\User;
use LaravelEnso\Core\Models\UserGroup;
use LaravelEnso\Menus\Models\Menu;
use LaravelEnso\Permissions\Models\Permission;
use LaravelEnso\Rememberable\Traits\Rememberable;
use LaravelEnso\Roles\Exceptions\RoleConflict;
use LaravelEnso\Roles\Services\ConfigWriter;
use LaravelEnso\Tables\Traits\TableCache;

class Role extends Model
{
    use HasFactory, Rememberable, TableCache;

    protected $guarded = ['id'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function userGroups()
    {
        return $this->belongsToMany(UserGroup::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    public function scopeVisible($query)
    {
        $fromAdminGroup = Auth::user()->belongsToAdminGroup();

        return $query->when(! $fromAdminGroup, fn ($query) => $query->whereHas(
            'userGroups',
            fn ($groups) => $groups->whereId(Auth::user()->group_id)
        ));
    }

    public function syncPermissions($permissionList)
    {
        $this->permissions()
            ->sync($permissionList);

        Cache::tags('roles')->flush();
    }

    public function hasPermission($name): bool
    {
        return Cache::tags('roles')->rememberForever(
            "has_permission:{$name}:roleId:{$this->id}",
            fn () => $this->permissions()->whereName($name)->exists()
        );
    }

    public function addDefaultPermissions()
    {
        $this->permissions()
            ->sync(Permission::implicit()->pluck('id'));
    }

    public function delete()
    {
        if ($this->users()->exists()) {
            throw RoleConflict::inUse();
        }

        parent::delete();
    }

    public function writeConfig()
    {
        (new ConfigWriter($this))->handle();
    }
}
