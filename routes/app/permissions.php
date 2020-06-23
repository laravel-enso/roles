<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Permission')
    ->prefix('permissions')->as('permissions.')
    ->group(function () {
        Route::get('get/{role}', 'Index')->name('get');
        Route::post('set/{role}', 'Update')->name('set');
        Route::post('write/{role}', 'ConfigWriter')->name('write');
    });
