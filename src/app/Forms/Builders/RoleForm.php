<?php

namespace LaravelEnso\Roles\App\Forms\Builders;

use LaravelEnso\Forms\App\Services\Form;
use LaravelEnso\Menus\App\Models\Menu;
use LaravelEnso\Roles\App\Models\Role;

class RoleForm
{
    protected const FormPath = __DIR__.'/../Templates/role.json';

    protected Form $form;

    public function __construct()
    {
        $this->form = (new Form(static::FormPath))
            ->options('menu_id', Menu::isNotParent()->get(['name', 'id']));
    }

    public function create()
    {
        return $this->form->create();
    }

    public function edit(Role $role)
    {
        return $this->form->edit($role);
    }
}
