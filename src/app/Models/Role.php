<?php

namespace LaravelEnso\RoleManager\app\Models;

use LaravelEnso\Core\app\Models\User;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\PermissionManager\app\Models\Permission;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class Role extends Model
{
    const AdminId = 1;
    const SupervisorId = 1;

    protected $fillable = ['name', 'display_name', 'description', 'menu_id'];

    public function menus()
    {
        return $this->belongsToMany(Menu::class)->withTimestamps();
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function owners()
    {
        return $this->belongsToMany(
            config('enso.config.ownerModel')
        );
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    public function getPermissionListAttribute()
    {
        return $this->permissions()
            ->pluck('id');
    }

    public function getMenuListAttribute()
    {
        return $this->menus()
            ->pluck('id');
    }

    public function storeWithPermissions(array $attributes)
    {
        \DB::transaction(function () use ($attributes) {
            $this->fill($attributes);

            tap($this)->save()
                ->permissions()
                ->attach(Permission::implicit()->pluck('id'));

            $this->menus()->attach($this->menu_id);
        });

        return $this;
    }

    public function updatePermissions(array $permissionIds)
    {
        $this->permissions()
            ->sync($permissionIds);
    }

    public function updateMenus(array $menuIds)
    {
        $this->menus()
            ->sync($menuIds);
    }

    public function delete()
    {
        if ($this->users()->count()) {
            throw new ConflictHttpException(__(
                'Operation failed because the role is in use'
            ));
        }

        parent::delete();
    }
}
