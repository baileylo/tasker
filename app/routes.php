<?php

Route::get('/', ['uses' => 'Task\Controller\Home@index']);

// Authentication Routes!

Route::post('/auth/login', ['uses' => 'Task\Controller\Auth@login']);
Route::post('/auth/logout', ['uses' => 'Task\Controller\Auth@logout']);


Route::get('/auth/login', ['uses' => 'Task\Controller\Auth@login']);

Route::get('/project/{projectId}', ['uses' => 'Task\Controller\Project\View@show', 'as' => 'project.view']);

Route::get('/project/{projectId}/ticket/create', ['uses' => 'Task\Controller\Ticket\Create@view', 'as' => 'ticket.create']);
Route::post('/project/{projectId}/ticket/create', ['uses' => 'Task\Controller\Ticket\Create@handle', 'as' => 'ticket.create']);

Route::get('/project/{objectId}/ticket/{ticketId}/view', ['uses' => 'Task\Controller\Ticket\View@show', 'as' => 'ticket.view']);


Route::post('/project/{objectId}/ticket/{ticketId}/close', ['uses' => 'Task\Controller\Ticket\Manager@close', 'as' => 'ticket.close']);
Route::post('/project/{objectId}/ticket/{ticketId}/add-comment', ['uses' => 'Task\Controller\Comment\Create@handle', 'as' => 'ticket.comment.add']);

## Admin Routes
Route::get('/admin', ['uses' => 'Task\Controller\Admin\Project\Overview@index', 'as' => 'admin.project.index']);

Route::get('/admin/project/create', ['uses' => 'Task\Controller\Admin\Project\Create@view', 'as' => 'project.create']);
Route::post('/admin/project/create', ['uses' => 'Task\Controller\Admin\Project\Create@handle']);

Route::get('/admin/project/{projectId}/delete', ['uses' => 'Task\Controller\Admin\Project\Delete@delete', 'as' => 'project.delete']);
Route::get('/admin/project/{projectId}/edit', ['uses' => 'Task\Controller\Admin\Project\Edit@show', 'as' => 'project.edit']);
Route::post('/admin/project/{projectId}/edit', ['uses' => 'Task\Controller\Admin\Project\Edit@handle', 'as' => 'project.edit']);

Route::get('/install', ['uses' => 'Task\Controller\Install@message', 'as' => 'install']);