<?php

Route::middleware(['web', 'auth', 'core'])
    ->prefix('api/system/roles')->as('system.roles.')
    ->namespace('LaravelEnso\Roles\app\Http\Controllers')
    ->group(function () {
        require 'app/roles.php';
    });
