<?php

Route::middleware(['web', 'auth', 'core'])
    ->namespace('LaravelEnso\RoleManager\app\Http\Controllers')
    ->group(function () {
        Route::prefix('system')->as('system.')
            ->group(function () {
                Route::prefix('roles')->as('roles.')
                    ->group(function () {
                        Route::get('initTable', 'RoleController@initTable')
                            ->name('initTable');
                        Route::get('getTableData', 'RoleController@getTableData')
                            ->name('getTableData');
                        Route::get('exportExcel', 'RoleController@exportExcel')
                            ->name('exportExcel');

                        Route::get('getOptionsList', 'RoleController@getOptionsList')
                            ->name('getOptionsList');
                        Route::get('getPermissions/{role}', 'RolePermissionController@getPermissions')
                            ->name('getPermissions');
                        Route::post('setPermissions', 'RolePermissionController@setPermissions')
                            ->name('setPermissions');
                    });

                Route::resource('roles', 'RoleController', ['except' => ['show']]);
            });
    });
