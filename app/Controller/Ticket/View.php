<?php namespace Task\Controller\Ticket;

use Controller, App, View as Template;
use Task\Model\Ticket;

class View extends Controller
{
    public function show($projectId, Ticket $ticket)
    {
        if ($projectId != $ticket->project_id) {
            App::abort(404);
        }

        return Template::make('ticket.show', compact('ticket'));
    }
} 