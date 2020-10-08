<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'auth', 'core'])
    ->prefix('api/system/roles')->as('system.roles.')
    ->group(function () {
        require 'app/roles.php';
        require 'app/permissions.php';
    });
