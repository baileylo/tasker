<?php namespace Task\Controller\Ticket;

use Controller, View, Input, Auth, Redirect;
use Task\Model\Project;
use Task\Model\Ticket;
use Task\Service\Validator\Ticket\Validator;

class Create extends Controller
{
    /** @var \Task\Service\Validator\Ticket\Validator  */
    protected $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function view(Project $project)
    {
        return View::make('ticket.create', compact('project'));
    }

    public function handle(Project $project)
    {
        $data = Input::only(['description', 'name', 'type', 'due_date']);

        if ($errors = $this->validator->getErrors($data)) {
            return Redirect::back()->withInput()->withErrors($errors);
        }

        $ticket = new Ticket();
        $ticket->reporter()->associate(Auth::user());
        $ticket->project()->associate($project);
        $ticket->description = $data['description'];
        $ticket->name = $data['name'];
        $ticket->type = $data['type'];
        $ticket->status = Ticket\Status::WAITING;
        $ticket->due_at = $data['due_date'];

        $ticket->save();

        if (Input::get('submission_type') === 'create_another') {
            return Redirect::route('ticket.create', $project->id);
        }

        return Redirect::route('project.view', [$project->id]);
    }
} 