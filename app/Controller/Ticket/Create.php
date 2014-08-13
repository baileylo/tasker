<?php namespace Task\Controller\Ticket;

use Controller, View, Input, Auth, Redirect;
use Illuminate\Support\MessageBag;
use Task\Model\Project;
use Task\Model\Ticket;
use Task\Model\User\RepositoryInterface as UserRepo;
use Task\Service\Validator\Ticket\Validator;

use Laracasts\Commander\CommanderTrait;
use Task\Service\Validator\ValidationFailedException;
use Task\Ticket\CreateTicketCommand;

class Create extends Controller
{
    use CommanderTrait;

    /** @var \Task\Service\Validator\Ticket\Validator  */
    protected $validator;

    /** @var \Task\Model\User\RepositoryInterface  */
    protected $userRepo;

    public function __construct(Validator $validator, UserRepo $userRepo)
    {
        $this->validator = $validator;
        $this->userRepo = $userRepo;
    }

    public function view(Project $project)
    {
        return View::make('ticket.create', compact('project'));
    }

    public function handle(Project $project)
    {
        $data = Input::only(['description', 'name', 'type', 'due_date', 'assignee']);
        $data['project'] = $project;
        $data['creator'] = Auth::user();

        try {
           $this->execute(CreateTicketCommand::class, $data, ['Task\\Ticket\\AssigneeConverter']);
        }
        catch(ValidationFailedException $exception)
        {
            return Redirect::back()->withInput()->withErrors($exception->getErrors());
        }

        $routeName = Input::get('submission_type') === 'create_another' ? 'ticket.create' : 'project.view';
        return Redirect::route($routeName, $project->id);
    }
} 