<?php

Route::middleware(['web', 'auth', 'core'])
    ->prefix('api/system/roles')->as('system.roles.')
    ->namespace('LaravelEnso\Roles\app\Http\Controllers')
    ->group(function () {
        Route::namespace('Role')
            ->group(function () {
                Route::get('create', 'Create')->name('create');
                Route::post('', 'Store')->name('store');
                Route::get('{role}/edit', 'Edit')->name('edit');
                Route::patch('{role}', 'Update')->name('update');
                Route::delete('{role}', 'Destroy')->name('destroy');

                Route::get('initTable', 'InitTable')->name('initTable');
                Route::get('tableData', 'TableData')->name('tableData');
                Route::get('exportExcel', 'ExportExcel')->name('exportExcel');

                Route::get('options', 'Options')->name('options');
            });

        Route::namespace('Configure')
            ->group(function () {
                Route::get('getPermissions/{role}', 'Index')->name('getPermissions');
                Route::post('setPermissions/{role}', 'Update')->name('setPermissions');
            });

        Route::post('writeConfig/{role}', 'ConfigWriter')->name('writeConfig');
    });
