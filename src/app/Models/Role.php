<?php

namespace LaravelEnso\Roles\app\Models;

use Illuminate\Support\Facades\Auth;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\Menus\app\Models\Menu;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Core\app\Models\UserGroup;
use LaravelEnso\Tables\app\Traits\TableCache;
use LaravelEnso\Permissions\app\Models\Permission;
use LaravelEnso\Rememberable\app\Traits\Rememberable;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

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
            throw new ConflictHttpException(__(
                'You cannot delete this role while being in use by users'
            ));
        }

        parent::delete();
    }

    public function scopeVisible($query)
    {
        return Auth::user()->belongsToAdminGroup()
            ? $query
            : $query->whereHas('userGroups', function ($userGroup) {
                $userGroup->whereId(Auth::user()->group_id);
            });
    }
}
