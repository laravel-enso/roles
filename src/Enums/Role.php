<?php

namespace LaravelEnso\Roles\Enums;

use LaravelEnso\Enums\Contracts\Frontend;

enum Role: int implements Frontend
{
    case Admin = 1;
    case Supervisor = 2;

    public function isAdmin()
    {
        return $this === self::Admin;
    }

    public function isSupervisor()
    {
        return $this === self::Supervisor;
    }

    public static function registerBy(): string
    {
        return 'roles';
    }
}
