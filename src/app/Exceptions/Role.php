<?php

namespace LaravelEnso\Roles\app\Exceptions;

use LaravelEnso\Helpers\app\Exceptions\EnsoException;

class Role extends EnsoException
{
    public static function adminConfig()
    {
        return new self(__("You don't need a config file for admin"));
    }

    public static function adminSync()
    {
        return new self(__('The admin role already has all permissions and does not need syncing'));
    }
}
