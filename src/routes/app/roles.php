<?php

use Illuminate\Support\Facades\Route;

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
