<?php

namespace LaravelEnso\Roles;

use LaravelEnso\Enums\EnumServiceProvider as ServiceProvider;
use LaravelEnso\Roles\App\Enums\Roles;

class EnumServiceProvider extends ServiceProvider
{
    public $register = [
        'roles' => Roles::class,
    ];
}
