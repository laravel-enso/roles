<?php

Route::group([
    'namespace'  => 'LaravelEnso\RoleManager\app\Http\Controllers',
    'middleware' => ['web', 'auth', 'core'],
], function () {
    Route::group(['prefix' => 'system', 'as' => 'system.'], function () {
        Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
            Route::get('initTable', 'RoleController@initTable')->name('initTable');
            Route::get('getTableData', 'RoleController@getTableData')->name('getTableData');
            Route::get('getOptionsList', 'RoleController@getOptionsList')->name('getOptionsList');
            Route::get('getPermissions/{role}', 'RolePermissionController@getPermissions')->name('getPermissions');
            Route::post('setPermissions', 'RolePermissionController@setPermissions')->name('setPermissions');
        });

        Route::resource('roles', 'RoleController');
    });
});
