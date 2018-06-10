<?php

namespace LaravelEnso\RoleManager\app\Classes;

use LaravelEnso\Helpers\app\Classes\Obj;
use LaravelEnso\PermissionManager\app\Models\PermissionGroup;

class TreeGenerator
{
    private $tree;
    private $branchNodesCount;

    public function __construct()
    {
        $this->tree = new Obj();
    }

    public function get()
    {
        $this->generate();

        return $this->tree;
    }

    private function generate()
    {
        $this->branches()
            ->each(function ($branch) {
                $this->build($branch);
            });
    }

    private function branches()
    {
        return PermissionGroup::with([
            'permissions' => function ($query) {
                $query->orderBy('name');
            }, ])->get();
    }

    private function build(PermissionGroup $branch)
    {
        $reference = $this->tree;

        $this->branchNodes($branch)
            ->each(function ($node, $index) use (&$reference, $branch) {
                if (!$reference->has($node)) {
                    $reference->$node = $this->isEndingNode($index)
                        ? $branch->permissions
                        : new Obj();
                }

                $reference = $reference->$node;
            });
    }

    private function branchNodes($branch)
    {
        $branchNodes = collect(
            explode('.', $branch->name)
        );

        $this->branchNodesCount = $branchNodes->count();

        return $branchNodes;
    }

    private function isEndingNode($index)
    {
        return $this->branchNodesCount - 1 === $index;
    }
}
