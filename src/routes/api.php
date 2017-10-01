<?php

Route::middleware(['auth:api', 'api', 'core'])
    ->prefix('api')
    ->namespace('LaravelEnso\RoleManager\app\Http\Controllers')
    ->group(function () {
        Route::prefix('system')->as('system.')
            ->group(function () {
                Route::prefix('roles')->as('roles.')
                    ->group(function () {
                        Route::get('initTable', 'RoleTableController@initTable')
                            ->name('initTable');
                        Route::get('getTableData', 'RoleTableController@getTableData')
                            ->name('getTableData');
                        Route::get('exportExcel', 'RoleTableController@exportExcel')
                            ->name('exportExcel');

                        Route::get('getOptionList', 'RoleSelectController@getOptionList')
                            ->name('getOptionList');

                        Route::get('getPermissions/{role}', 'RolePermissionController@index')
                            ->name('getPermissions');
                        Route::post('setPermissions', 'RolePermissionController@update')
                            ->name('setPermissions');
                    });

                Route::resource('roles', 'RoleController', ['except' => ['show']]);
            });
    });
