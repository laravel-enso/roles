<?php

Route::middleware(['web', 'auth', 'core'])
    ->prefix('api/system')->as('system.')
    ->namespace('LaravelEnso\RoleManager\app\Http\Controllers')
    ->group(function () {
        Route::prefix('roles')->as('roles.')
            ->group(function () {
                Route::get('initTable', 'RoleTableController@init')
                    ->name('initTable');
                Route::get('getTableData', 'RoleTableController@data')
                    ->name('getTableData');
                Route::get('exportExcel', 'RoleTableController@excel')
                    ->name('exportExcel');

                Route::get('selectOptions', 'RoleSelectController@options')
                    ->name('selectOptions');

                Route::get('getPermissions/{role}', 'RoleConfiguratorController@index')
                    ->name('getPermissions');
                Route::post('setPermissions/{role}', 'RoleConfiguratorController@update')
                    ->name('setPermissions');

                Route::post('writeConfig/{role}', 'ConfigWriterController')
                    ->name('writeConfig');
            });

        Route::resource('roles', 'RoleController', ['except' => ['show', 'index']]);
    });
