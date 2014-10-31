<?php namespace Portico\Task\Http\Controller\Ticket;

use Controller, App, View as Template;
use Illuminate\Session\Store as SessionStore;
use Illuminate\Support\ViewErrorBag;
use Portico\Task\Ticket\Ticket;
use Portico\Task\ViewHelpers\Views\ShowTicket\FormViewHelper;

class View extends Controller
{
    /** @var Store */
    private $session;

    public function __construct(SessionStore $session)
    {
        $this->session = $session;
    }

    public function show($projectId, Ticket $ticket)
    {
        /** @todo Add filter to validate that projectId and Ticket->project_id are equal. */
        if ($projectId != $ticket->project_id) {
            App::abort(404);
        }

        // Load in all comments and authors of said comments.
        // This prevents the n+1 query issue.
        $ticket->load('comments.author');

        /**
         * Laravel automatically injects 'errors' variable, but we want to break
         * it out into 2 variables, closeTicketErrors and CommentErrors. We must
         * do that in the controller here.
         *
         * @var ViewErrorBag $errors
         */
        $errors = $this->session->get('errors', new ViewErrorBag());
        $editErrors = $errors->getBag('editTicketErrors');
        $commentErrors = $errors->getBag('addComment');

        $helper = new FormViewHelper($editErrors, $commentErrors);

        return Template::make('ticket.show', compact('ticket', 'editErrors', 'commentErrors', 'helper'));
    }
} 