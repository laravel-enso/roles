<?php

namespace LaravelEnso\Roles\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use LaravelEnso\Menus\Models\Menu;
use LaravelEnso\Permissions\Models\Permission;
use LaravelEnso\Rememberable\Traits\Rememberable;
use LaravelEnso\Roles\Exceptions\RoleConflict;
use LaravelEnso\Roles\Services\ConfigWriter;
use LaravelEnso\Tables\Traits\TableCache;
use LaravelEnso\UserGroups\Enums\UserGroups;
use LaravelEnso\UserGroups\Models\UserGroup;
use LaravelEnso\Users\Models\User;

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

    public function scopeVisible(Builder $query): Builder
    {
        $isSuperior = Auth::user()->belongsToAdminGroup();

        return $query->when(! $isSuperior, fn ($query) => $query
            ->whereHas('userGroups', fn ($groups) => $groups->when(
                Config::get('enso.roles.restrictedToOwnGroup'),
                fn ($groups) => $groups->whereId(Auth::user()->group_id),
                fn ($groups) => $groups->where('id', '<>', UserGroups::Admin),
            )));
    }

    public function syncPermissions($permissionList)
    {
        $this->permissions()
            ->sync($permissionList);
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
