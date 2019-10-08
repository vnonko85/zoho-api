<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'ZohoApiController@index')->name('home');

Route::get('oauth2callback', 'ZohoApiController@callback');

Route::post('deals/create', 'ZohoApiController@dealCreate')->name('deal.create');
Route::post('tasks/create', 'ZohoApiController@taskCreate')->name('task.create');