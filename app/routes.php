<?php

View::composer('layout.master', function($view)
{
    if (Session::has('email')) {
        $view->with('currentUser', '"' . Session::get('email') . '"');
        return true;
    }

    if (Auth::check()) {
        $view->with('currentUser', '"' . Auth::user()->email . '"');

        return true;
    }

    $view->with('currentUser', 'null');
});

Event::listen('Task.*', 'Portico\Task\Ticket\Listeners\WatcherListener');
Event::listen('Task.*', 'Portico\Task\Project\Listeners\WatcherListener');
Event::listen('Task.*', 'Portico\Task\Project\Listeners\StreamBuilderListener');


Route::get('force-login', function() {
    $user = \Portico\Task\User\User::find(1);
    Auth::login($user);

    return Redirect::intended();
});

Route::get('/', ['uses' => 'Portico\Task\Http\Controller\Home@home', 'as' => 'home']);
Route::get('/login', ['uses' => 'Portico\Task\Http\Controller\Home@login', 'as' => 'login']);

// Authentication Routes!

Route::post('/auth/login', ['uses' => 'Portico\Task\Http\Controller\Auth@login']);
Route::post('/auth/logout', ['uses' => 'Portico\Task\Http\Controller\Auth@logout']);
Route::get('/auth/login', ['uses' => 'Portico\Task\Http\Controller\Auth@login']);

Route::get('/registration', ['uses' => 'Portico\Task\Http\Controller\User\Registration@show', 'as' => 'registration']);
Route::post('/registration', ['uses' => 'Portico\Task\Http\Controller\User\Registration@handle', 'as' => 'registration']);

Route::get('/my-projects', ['uses' => 'Portico\Task\Http\Controller\User\Project@show', 'as' => 'user.projects']);

Route::get('/project/{projectId}', ['uses' => 'Portico\Task\Http\Controller\Project\View@show', 'as' => 'project.view']);
Route::put('/project/{projectId}/watch', ['before' => 'csrf', 'uses' => 'Portico\Task\Http\Controller\Project\Watch@watch', 'as' => 'project.watch']);
Route::put('/project/{projectId}/unwatch', ['before' => 'csrf', 'uses' => 'Portico\Task\Http\Controller\Project\Watch@unwatch', 'as' => 'project.unwatch']);

Route::get('/project/{projectId}/ticket/create', ['uses' => 'Portico\Task\Http\Controller\Ticket\Create@view', 'as' => 'ticket.create']);
Route::post('/project/{projectId}/ticket/create', ['uses' => 'Portico\Task\Http\Controller\Ticket\Create@handle', 'as' => 'ticket.create']);

Route::get('/project/{objectId}/ticket/{ticketId}/view', ['uses' => 'Portico\Task\Http\Controller\Ticket\View@show', 'as' => 'ticket.view']);
Route::post('/project/{objectId}/ticket/{ticketId}/edit', ['uses' => 'Portico\Task\Http\Controller\Ticket\Edit@edit', 'as' => 'ticket.edit']);
Route::post('/project/{objectId}/ticket/{ticketId}/add-comment', ['uses' => 'Portico\Task\Http\Controller\Comment\Create@handle', 'as' => 'ticket.comment.add']);

## Admin Routes
Route::get('/admin', ['uses' => 'Task\Controller\Admin\Project\Overview@index', 'as' => 'admin.project.index']);

Route::get('/admin/project/create', ['uses' => 'Portico\Task\Http\Controller\Admin\Project\Create@view', 'as' => 'project.create']);
Route::post('/admin/project/create', ['uses' => 'Portico\Task\Http\Controller\Admin\Project\Create@handle']);

Route::get('/admin/project/{projectId}/delete', ['uses' => 'Portico\Task\Http\Controller\Admin\Project\Delete@delete', 'as' => 'project.delete']);
Route::get('/admin/project/{projectId}/edit', ['uses' => 'Portico\Task\Http\Controller\Admin\Project\Edit@show', 'as' => 'project.edit']);
Route::post('/admin/project/{projectId}/edit', ['uses' => 'Portico\Task\Http\Controller\Admin\Project\Edit@handle', 'as' => 'project.edit']);

Route::get('/install', ['uses' => 'Portico\Task\Http\Controller\Install@message', 'as' => 'install']);