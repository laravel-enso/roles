<?php

namespace LaravelEnso\RoleManager\app\Models;

use App\User;
use App\Owner;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\PermissionManager\app\Models\Permission;
use LaravelEnso\DbSyncMigrations\app\Traits\DbSyncMigrations;

class Role extends Model
{
    use DbSyncMigrations;

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
        return $this->belongsToMany(Owner::class);
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
        return $this->permissions->pluck('id');
    }

    public function getMenuListAttribute()
    {
        return $this->menus->pluck('id')->toArray();
    }
}
