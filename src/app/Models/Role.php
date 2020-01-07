<?php

namespace LaravelEnso\Roles\App\Models;

use App\Exceptions\RoleConflict;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use LaravelEnso\Core\App\Models\User;
use LaravelEnso\Core\App\Models\UserGroup;
use LaravelEnso\Menus\App\Models\Menu;
use LaravelEnso\Permissions\App\Models\Permission;
use LaravelEnso\Rememberable\App\Traits\Rememberable;
use LaravelEnso\Tables\App\Traits\TableCache;

class Role extends Model
{
    use Rememberable, TableCache;

    protected $fillable = ['menu_id', 'name', 'display_name', 'description'];

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

    public function scopeVisible($query)
    {
        $fromAdminGroup = Auth::user()->belongsToAdminGroup();

        return $query->when($fromAdminGroup, fn ($query) => $query->whereHas(
            'userGroups', fn ($groups) => $groups->whereId(Auth::user()->group_id)
        ));
    }
}
