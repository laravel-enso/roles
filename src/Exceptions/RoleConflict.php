<?php

namespace LaravelEnso\Roles\Exceptions;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class RoleConflict extends ConflictHttpException
{
    public static function inUse()
    {
        return new self(__(
            'You cannot delete this role while being in use by users'
        ));
    }
}
