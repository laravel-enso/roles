<?php

namespace LaravelEnso\RoleManager\app\Http\Services;

use Illuminate\Http\Request;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\PermissionManager\app\Models\Permission;
use LaravelEnso\RoleManager\app\Models\Role;
use LaravelEnso\Select\app\Traits\SelectListBuilder;

class RoleService
{
    use SelectListBuilder;

    private $request;

    protected $selectSourceClass = Role::class;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getTableQuery()
    {
        $query = Role::select(\DB::raw('roles.id as DT_RowId, roles.name,
            roles.display_name, roles.description, roles.created_at, roles.updated_at,
            roles.menu_id')
        );

        return $query;
    }

    public function index()
    {
        return view('laravel-enso/rolemanager::index');
    }

    public function create()
    {
        $menus = Menu::pluck('name', 'id');

        return view('laravel-enso/rolemanager::create', compact('menus'));
    }

    public function store(Role $role)
    {
    	\DB::transaction(function() use (&$role) {
	        $role = $role->create($this->request->all());
	        $permissions = Permission::implicit()->pluck('id');
	        $role->permissions()->attach($permissions);
	        $role->menus()->attach($role->menu_id);
	        flash()->success(__('The role was created'));
		});

        return redirect('system/roles/' . $role->id . '/edit');
    }

    public function edit(Role $role)
    {
        $menus = Menu::isNotParent()->pluck('name', 'id');

        return view('laravel-enso/rolemanager::edit', compact('role', 'menus'));
    }

    public function update(Role $role)
    {
        $role->update($this->request->all());
        $role->save();
        flash()->success(__('The changes have been saved!'));

        return back();
    }

    public function destroy(Role $role)
    {
        if ($role->users->count()) {
            throw new \EnsoException(__("Operation failed because the role is in use"));
        }

        $role->delete();

        return ['message' => __('Operation was successfull')];
    }
}
