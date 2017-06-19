<?php

Route::group([
    'namespace' => 'LaravelEnso\RoleManager\app\Http\Controllers',
    'middleware' => ['web', 'auth', 'core']
], function () {
    Route::group(['prefix' => 'system', 'as' => 'system.'], function () {
        Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
            Route::get('initTable', 'RolesController@initTable')->name('initTable');
            Route::get('getTableData', 'RolesController@getTableData')->name('getTableData');
            Route::get('getPermissions/{role}', 'RolesController@getPermissions')->name('getPermissions');
            Route::get('getOptionsList', 'RolesController@getOptionsList')->name('getOptionsList');
            Route::post('setPermissions', 'RolesController@setPermissions')->name('setPermissions');
        });

        Route::resource('roles', 'RolesController');
    });
});
