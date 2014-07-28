<?php namespace Task\Controller\Ticket;

use Controller, View, Input, Auth, Redirect;
use Task\Model\Comment;
use Task\Model\Project;
use Task\Model\Ticket;
use Task\Service\Validator\Ticket\Close;

class Manager extends Controller
{
    /** @var \Task\Service\Validator\Ticket\Close  */
    protected $closeTicketValidator;

    public function __construct(Close $validator)
    {
        $this->closeTicketValidator = $validator;
    }

    public function close($projectId, Ticket $ticket)
    {
        $input = Input::only('comment', 'status');

        if ($errors = $this->closeTicketValidator->getErrors($input)) {
            return Redirect::back()->withInput()->withErrors($errors);
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