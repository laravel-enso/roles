<?php

namespace LaravelEnso\Roles;

use LaravelEnso\Roles\app\Enums\Roles;
use LaravelEnso\Enums\EnumServiceProvider as ServiceProvider;

class EnumServiceProvider extends ServiceProvider
{
    public $register = [
        'roles' => Roles::class,
    ];
}
