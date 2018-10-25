<?php

namespace LaravelEnso\RoleManager\app\Classes;

use LaravelEnso\Helpers\app\Classes\Obj;
use LaravelEnso\PermissionManager\app\Models\Permission;

class PermissionTree
{
    private $tree;
    private $current;
    private $branchNodesCount;

    public function __construct()
    {
        $this->tree = $this->emptyNode();
    }

    public function get()
    {
        Permission::with('menu:permission_id')
            ->orderBy('name')
            ->get()
            ->each(function ($permission) {
                $this->current = $this->tree;
                $this->setEndingNode($permission);
                $this->current->get('_items')
                    ->push($permission);
            });

        return $this->tree;
    }

    private function setEndingNode($permission)
    {
        collect(explode('.', $permission->name))
            ->slice(0, -1)->each(function ($segment) {
                if (! $this->current->has($segment)) {
                    $this->current->set($segment, $this->emptyNode());
                }

                $this->current = $this->current->get($segment);
            });
    }

    private function emptyNode()
    {
        return new Obj([
            '_items' => collect(),
        ]);
    }
}
