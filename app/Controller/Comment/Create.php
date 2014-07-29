<?php namespace Task\Controller\Comment;

use Controller, View, Input, Auth, Redirect;
use Illuminate\Support\MessageBag;
use Task\Model\Comment;
use Task\Model\Ticket;
use Task\Service\Validator\Comment\Validator;

class Create extends Controller
{
    /** @var \Task\Service\Validator\Comment\Validator  */
    protected $validator;

    public function __construct(Validator $validator)
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