<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['as' => 'home', 'uses' => 'DashboardController@index']);

Route::get('taskboard', ['as' => 'taskboard.index', 'uses' => 'TaskboardController@index']);
Route::put('taskboard', ['as' => 'taskboard.update-status', 'uses' => 'TaskboardController@updateStatus']);
Route::get('issuetracker', ['as' => 'issuetracker.index', 'uses' => 'IssuetrackerController@index']);