<?php namespace Portico\Task\Http\Controller\Ticket;

use Controller, Input, Auth, Redirect;
use Portico\Task\Comment\Comment;
use Portico\Task\Ticket\Ticket;
use Portico\Task\Ticket\Validator\CloseTicketValidator;

class Manager extends Controller
{
    /** @var CloseTicketValidator  */
    protected $closeTicketValidator;

    public function __construct(CloseTicketValidator $validator)
    {
        $this->closeTicketValidator = $validator;
    }

    public function close($projectId, Ticket $ticket)
    {
        $input = Input::only('comment', 'status');

        if ($errors = $this->closeTicketValidator->getErrors($input)) {
            return Redirect::back()->withInput()->withErrors($errors, 'closeTicket');
        }

        $comment = new Comment();
        $comment->message = $input['comment'];
        $comment->author()->associate(Auth::user());
        $comment->ticket()->associate($ticket);

        $ticket->status = intval($input['status']);
        $ticket->comments()->save($comment);
        $ticket->save();

        return Redirect::route('ticket.view', [$ticket->project_id, $ticket->id])->with('notification', 'Ticket closed');
    }
} 