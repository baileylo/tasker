<?php namespace Portico\Task\Http\Controller\Ticket;

use Controller, View, Input, Auth, Redirect;
use Laracasts\Commander\CommanderTrait;
use Portico\Core\Validator\ValidationFailedException;
use Portico\Task\Project\Project;
use Portico\Task\Ticket\Command\CreateTicketCommand;
use Portico\Task\User\UserRepository;

class Create extends Controller
{
    use CommanderTrait;

    /** @var UserRepository */
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
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