<?php

use LaravelEnso\StructureManager\app\Classes\StructureMigration;

class CreateStructureForRoles extends StructureMigration
{
    protected $permissionGroup = [
        'name' => 'system.roles', 'description' => 'Roles permissions group',
    ];

    protected $permissions = [
        ['name' => 'system.roles.getTableData', 'description' => 'Get table data for roles', 'type' => 0, 'default' => false],
        ['name' => 'system.roles.exportExcel', 'description' => 'Export excel for roles', 'type' => 0, 'default' => false],
        ['name' => 'system.roles.initTable', 'description' => 'Init table for roles menu', 'type' => 0, 'default' => false],
        ['name' => 'system.roles.create', 'description' => 'Create role', 'type' => 1, 'default' => false],
        ['name' => 'system.roles.edit', 'description' => 'Edit role', 'type' => 1, 'default' => false],
        ['name' => 'system.roles.index', 'description' => 'Show roles index', 'type' => 0, 'default' => false],
        ['name' => 'system.roles.store', 'description' => 'Store newly created role', 'type' => 1, 'default' => false],
        ['name' => 'system.roles.update', 'description' => 'Update role', 'type' => 1, 'default' => false],
        ['name' => 'system.roles.destroy', 'description' => 'Delete role', 'type' => 1, 'default' => false],
        ['name' => 'system.roles.selectOptions', 'description' => 'Get role permissions list for vue-select', 'type' => 0, 'default' => true],
        ['name' => 'system.roles.getPermissions', 'description' => 'Get role permissions for role configurator', 'type' => 0, 'default' => false],
        ['name' => 'system.roles.setPermissions', 'description' => 'Set role permissions for role configurator', 'type' => 1, 'default' => false],
    ];

    protected $menu = [
        'name' => 'Roles', 'icon' => 'universal-access', 'link' => 'system.roles.index', 'has_children' => false,
    ];

    protected $parentMenu = 'System';
}
