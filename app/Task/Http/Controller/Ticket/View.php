<?php namespace Portico\Task\Http\Controller\Ticket;

use Controller, App, View as Template;
use Portico\Task\Ticket\Ticket;

class View extends Controller
{
    public function show($projectId, Ticket $ticket)
    {
        if ($projectId != $ticket->project_id) {
            App::abort(404);
        }

        $ticket->load('comments.author');

        return Template::make('ticket.show', compact('ticket'));
    }
} 