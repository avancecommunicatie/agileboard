<?php

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index', 'middleware' => 'auth']);

//Route::get('taskboard/{projectgroup_id}/sprintless', ['as' => 'taskboard.sprintless', 'uses' => 'TaskboardController@sprintless', 'middleware' => 'auth']);
Route::get('taskboard/{projectgroup_id}/{sprint_id?}', ['as' => 'taskboard.index', 'uses' => 'TaskboardController@index', 'middleware' => 'auth']);
Route::post('taskboard/update-status', ['as' => 'taskboard.update-status', 'uses' => 'TaskboardController@updateStatus', 'middleware' => 'auth']);
Route::post('taskboard/change-handler', ['as' => 'taskboard.change-handler', 'uses' => 'TaskboardController@changeHandler', 'middleware' => 'auth']);
Route::post('taskboard/change-sprint', ['as' => 'taskboard.change-sprint', 'uses' => 'TaskboardController@changeSprint', 'middleware' => 'auth']);
Route::post('taskboard/change-project', ['as' => 'taskboard.change-project', 'uses' => 'TaskboardController@changeProject', 'middleware' => 'auth']);
Route::post('taskboard/clear-sprint', ['as' => 'taskboard.clear-sprint', 'uses' => 'TaskboardController@clearSprint', 'middleware' => 'auth']);

Route::get('storyboard/{projectgroup_id?}/{sprint_id?}', ['as' => 'storyboard.index', 'uses' => 'StoryboardController@index', 'middleware' => 'auth']);
Route::post('storyboard', ['as' => 'storyboard.store', 'uses' => 'StoryboardController@store', 'middleware' => 'auth']);
Route::delete('storyboard/{id}', ['as' => 'storyboard.destroy', 'uses' => 'StoryboardController@destroy', 'middleware' => 'auth']);
Route::post('storyboard/change-sprint', ['as' => 'storyboard.change-sprint', 'uses' => 'StoryboardController@changeSprint', 'middleware' => 'auth']);
Route::post('storyboard/change-project', ['as' => 'storyboard.change-project', 'uses' => 'StoryboardController@changeProject', 'middleware' => 'auth']);

Route::resource('projectgroup', 'ProjectgroupController');