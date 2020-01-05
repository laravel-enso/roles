<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Configure')
    ->group(function () {
        Route::get('getPermissions/{role}', 'Index')->name('getPermissions');
        Route::post('setPermissions/{role}', 'Update')->name('setPermissions');
    });
