<?php namespace Task\Controller\Ticket;

use Controller, View, Input, Auth, Redirect;
use Task\Model\Comment;
use Task\Model\Project;
use Task\Model\Ticket;

class Manager extends Controller
{

    public function close($projectId, Ticket $ticket)
    {
        $input = Input::only('comment', 'type');
        $comment = new Comment();
        $comment->message = $input['comment'];
        $comment->author()->associate(Auth::user());
        $comment->ticket()->associate($ticket);

        return $comment;




        return Redirect::route('ticket.view', [$project->id, $ticket->id])->with('notification', 'Ticket closed');
    }
} 