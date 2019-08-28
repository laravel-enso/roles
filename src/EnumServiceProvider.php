<?php

namespace LaravelEnso\Roles;

use LaravelEnso\Roles\app\Enums\Roles;
use LaravelEnso\IO\EnumServiceProvider as ServiceProvider;

class EnumServiceProvider extends ServiceProvider
{
    protected $register = [
        'roles' => Roles::class,
    ];
}
