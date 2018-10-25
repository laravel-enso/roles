<?php

Route::middleware(['web', 'auth', 'core'])
    ->prefix('api/system')->as('system.')
    ->namespace('LaravelEnso\RoleManager\app\Http\Controllers')
    ->group(function () {
        Route::prefix('roles')->as('roles.')
            ->group(function () {
                Route::get('initTable', 'RoleTableController@init')
                    ->name('initTable');
                Route::get('tableData', 'RoleTableController@data')
                    ->name('tableData');
                Route::get('exportExcel', 'RoleTableController@excel')
                    ->name('exportExcel');

                Route::get('options', 'RoleSelectController@options')
                    ->name('options');

                Route::get('getPermissions/{role}', 'RoleConfiguratorController@index')
                    ->name('getPermissions');
                Route::post('setPermissions/{role}', 'RoleConfiguratorController@update')
                    ->name('setPermissions');

                Route::post('writeConfig/{role}', 'ConfigWriterController')
                    ->name('writeConfig');
            });

        Route::resource('roles', 'RoleController', ['except' => ['show', 'index']]);
    });
