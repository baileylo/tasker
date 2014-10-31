<?php namespace Portico\Task\Http\Controller\Ticket;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Laracasts\Commander\CommanderTrait;
use Portico\Core\Validator\ValidationFailedException;
use Portico\SessionUser\SessionUser;
use Portico\Task\Ticket\Command\Decorator\AssigneeIdConverter;
use Portico\Task\Ticket\Command\EditTicketCommand;
use Portico\Task\Ticket\Ticket;
use Redirect;

class Edit extends Controller
{
    use CommanderTrait;

    /** @var Request */
    private $request;

    /** @var Redirector */
    private $redirector;

    /** @var User */
    private $user;

    public function __construct(Request $request, Redirector $redirector, SessionUser $user)
    {
        $this->request = $request;
        $this->redirector = $redirector;
        $this->user = $user;
    }

    public function edit($projectId, Ticket $ticket)
    {
        $data = $this->request->only('name', 'assignee_id', 'status', 'type', 'due_date', 'description', 'comment');
        $data['ticket'] = $ticket;
        $data['editor'] = $this->user;

        try {
            $this->execute(EditTicketCommand::class, $data, [AssigneeIdConverter::class]);
        }
        catch(ValidationFailedException $exception)
        {
            return Redirect::back()->withInput()->withErrors($exception->getErrors(), 'editTicketErrors');
        }

        return $this->redirector->route('ticket.view', [$projectId, $ticket->id]);
    }
} 