<?php

use Illuminate\Support\Facades\Route;
use LaravelEnso\Roles\Http\Controllers\Permission\ConfigWriter;
use LaravelEnso\Roles\Http\Controllers\Permission\Index;
use LaravelEnso\Roles\Http\Controllers\Permission\Update;

Route::prefix('permissions')->as('permissions.')
    ->group(function () {
        Route::get('get/{role}', Index::class)->name('get');
        Route::post('set/{role}', Update::class)->name('set');
        Route::post('write/{role}', ConfigWriter::class)->name('write');
    });
