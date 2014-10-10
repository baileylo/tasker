<?php namespace Portico\Task\Http\Controller\Comment;

use Controller, Input, Auth, Redirect;
use Portico\Task\Comment\Comment;
use Portico\Task\Ticket\Ticket;
use Portico\Task\Comment\CommentValidator;

class Create extends Controller
{
    /** @var CommentValidator  */
    protected $validator;

    public function __construct(CommentValidator $validator)
    {
        $this->validator = $validator;
    }

    public function handle($projectId, Ticket $ticket)
    {
        $data = Input::only(['comment']);

        if ($errors = $this->validator->getErrors($data)) {
            return Redirect::back()->withInput()->withErrors($errors);
        }

        $comment = new Comment();
        $comment->author()->associate(Auth::user());
        $comment->ticket()->associate($ticket);
        $comment->message = $data['comment'];

        $comment->save();

        return Redirect::route('ticket.view', [$ticket->project_id, $ticket->id]);
    }
} 