<?php

namespace LaravelEnso\RoleManager\app\DataTable;

use LaravelEnso\DataTable\app\Classes\TableStructure;

class RolesTableStructure extends TableStructure
{
    public function __construct()
    {
        $this->data = [
            'name'                => __('Roles'),
            'icon'                => 'fa fa-universal-access',
            'crtNo'               => __('#'),
            'actions'             => __('Actions'),
            'actionButtons'       => ['edit', 'destroy'],
            'customActionButtons' => [
                ['icon' => 'fa fa-sliders', 'class' => 'is-info', 'event' => 'configure-role', 'route' => 'system.roles.getPermissions'],
            ],
            'headerButtons'       => ['create', 'exportExcel'],
            'notSearchable'       => [3, 4],
            'headerAlign'         => 'center',
            'bodyAlign'           => 'center',
            'columns'             => [
                0 => [
                    'label' => __('Name'),
                    'data'  => 'name',
                    'name'  => 'name',
                ],
                1 => [
                    'label' => __('Display Name'),
                    'data'  => 'display_name',
                    'name'  => 'display_name',
                ],
                2 => [
                    'label' => __('Description'),
                    'data'  => 'description',
                    'name'  => 'description',
                ],
                3 => [
                    'label' => __('Created At'),
                    'data'  => 'created_at',
                    'name'  => 'created_at',
                ],
                4 => [
                    'label' => __('Updated At'),
                    'data'  => 'updated_at',
                    'name'  => 'updated_at',
                ],
            ],
        ];
    }
}
