<?php

namespace LaravelEnso\Roles\app\Forms\Builders;

use LaravelEnso\Menus\app\Models\Menu;
use LaravelEnso\Roles\app\Models\Role;
use LaravelEnso\Forms\app\Services\Form;

class RoleForm
{
    protected const FormPath = __DIR__.'/../Templates/role.json';

    protected $form;

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
