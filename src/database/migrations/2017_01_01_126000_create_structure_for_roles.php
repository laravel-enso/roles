<?php

use LaravelEnso\Migrator\App\Database\Migration;
use LaravelEnso\Permissions\App\Enums\Types;

class CreateStructureForRoles extends Migration
{
    protected $permissions = [
        ['name' => 'system.roles.tableData', 'description' => 'Get table data for roles', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'system.roles.exportExcel', 'description' => 'Export excel for roles', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'system.roles.initTable', 'description' => 'Init table for roles menu', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'system.roles.create', 'description' => 'Create role', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'system.roles.edit', 'description' => 'Edit role', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'system.roles.configure', 'description' => 'Configure role permissions', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'system.roles.index', 'description' => 'Show roles index', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'system.roles.store', 'description' => 'Store newly created role', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'system.roles.update', 'description' => 'Update role', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'system.roles.destroy', 'description' => 'Delete role', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'system.roles.options', 'description' => 'Get options for select', 'type' => Types::Read, 'is_default' => true],
        ['name' => 'system.roles.getPermissions', 'description' => 'Get role permissions for role configurator', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'system.roles.setPermissions', 'description' => 'Set role permissions for role configurator', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'system.roles.writeConfig', 'description' => 'Write role configuration file', 'type' => Types::Write, 'is_default' => false],
    ];

    protected $menu = [
        'name' => 'Roles', 'icon' => 'universal-access', 'route' => 'system.roles.index', 'order_index' => 999, 'has_children' => false,
    ];

    protected $parentMenu = 'System';
}
