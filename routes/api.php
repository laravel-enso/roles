<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'auth', 'core'])
    ->prefix('api/system/roles')->as('system.roles.')
    ->group(function () {
        require __DIR__.'/app/roles.php';
        require __DIR__.'/app/permissions.php';
    });
