<?php

namespace LaravelEnso\Roles;

use LaravelEnso\Enums\EnumServiceProvider as ServiceProvider;
use LaravelEnso\Roles\Enums\Role;

class EnumServiceProvider extends ServiceProvider
{
    public $register = [
        'roles' => Role::class,
    ];
}
