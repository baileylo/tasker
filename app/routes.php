<?php

Auth::loginUsingId(1);

Route::get('/', ['uses' => 'Task\Controller\Home@index']);

// Authentication Routes!

Route::post('/auth/login', ['uses' => 'Task\Controller\Auth@login']);
Route::post('/auth/logout', ['uses' => 'Task\Controller\Auth@logout']);


Route::get('/auth/login', ['uses' => 'Task\Controller\Auth@login']);

Route::get('/project/{projectSlug}', ['uses' => 'Task\Controller\Project\View@show', 'as' => 'project.view']);

## Admin Routes
Route::get('/admin', ['uses' => 'Task\Controller\Admin\Project\Overview@index', 'as' => 'admin.project.index']);

Route::get('/admin/project/create', ['uses' => 'Task\Controller\Admin\Project\Create@view', 'as' => 'project.create']);
Route::post('/admin/project/create', ['uses' => 'Task\Controller\Admin\Project\Create@handle']);

Route::get('/admin/project/{projectId}/delete', ['uses' => 'Task\Controller\Admin\Project\Delete@delete', 'as' => 'project.delete']);
Route::get('/admin/project/{projectId}/edit', ['uses' => 'Task\Controller\Admin\Project\Edit@show', 'as' => 'project.edit']);
Route::post('/admin/project/{projectId}/edit', ['uses' => 'Task\Controller\Admin\Project\Edit@handle', 'as' => 'project.edit']);