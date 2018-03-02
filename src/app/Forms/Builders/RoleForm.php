<?php

namespace LaravelEnso\RoleManager\app\Forms\Builders;

use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\RoleManager\app\Models\Role;
use LaravelEnso\FormBuilder\app\Classes\Form;

class RoleForm
{
    private const FormPath = __DIR__.'/../Templates/role.json';

    private $form;

    public function __construct()
    {
        $this->form = new Form(self::FormPath);
    }

    public function create()
    {
        return $this->form
            ->options('menu_id', Menu::isNotParent()->get(['name', 'id']))
            ->create();
    }

    public function edit(Role $role)
    {
        return $this->form
            ->options('menu_id', Menu::isNotParent()->get(['name', 'id']))
            ->edit($role);
    }
}
