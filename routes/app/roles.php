<?php

use Illuminate\Support\Facades\Route;
use LaravelEnso\Roles\Http\Controllers\Create;
use LaravelEnso\Roles\Http\Controllers\Destroy;
use LaravelEnso\Roles\Http\Controllers\Edit;
use LaravelEnso\Roles\Http\Controllers\ExportExcel;
use LaravelEnso\Roles\Http\Controllers\InitTable;
use LaravelEnso\Roles\Http\Controllers\Options;
use LaravelEnso\Roles\Http\Controllers\Store;
use LaravelEnso\Roles\Http\Controllers\TableData;
use LaravelEnso\Roles\Http\Controllers\Update;

Route::get('create', Create::class)->name('create');
Route::post('', Store::class)->name('store');
Route::get('{role}/edit', Edit::class)->name('edit');
Route::patch('{role}', Update::class)->name('update');
Route::delete('{role}', Destroy::class)->name('destroy');

Route::get('initTable', InitTable::class)->name('initTable');
Route::get('tableData', TableData::class)->name('tableData');
Route::get('exportExcel', ExportExcel::class)->name('exportExcel');

Route::get('options', Options::class)->name('options');
