<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'core'])
    ->prefix('api/system/roles')->as('system.roles.')
    ->namespace('LaravelEnso\Roles\App\Http\Controllers')
    ->group(function () {
        require 'app/roles.php';
        require 'app/configure.php';
        //TODO refactor routes
        Route::post('writeConfig/{role}', 'ConfigWriter')->name('writeConfig');
    });
