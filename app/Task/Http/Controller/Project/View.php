<?php namespace Portico\Task\Http\Controller\Project;

use Controller, View as Template;
use Portico\Task\Project\Project;
use Portico\Task\Ticket\Enum\Status;
use Portico\Task\Ticket\TicketRepository;

class View extends Controller
{
    /** @var TicketRepository  */
    protected $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function show(Project $project)
    {
        $open = $project->openTickets()->limit(5)->orderBy('updated_at', 'desc')->get();
        $closed = $project->closedTickets()->limit(5)->orderBy('updated_at', 'desc')->get();
        $upcoming = $project->openTickets()->whereNotNull('due_at')->limit(5)->orderBy('due_at', 'desc')->get();

        $openIssueCount = $project->open_ticket_count;
        $closedIssueCount = $project->closed_ticket_count;

        $tickets = $project->openTickets()->with(['commentCount', 'reporter'])
            ->orderBy('tickets.created_at')
            ->paginate(15);

        return Template::make('project.show', compact('project', 'open', 'closed', 'upcoming', 'openIssueCount', 'closedIssueCount', 'tickets'));
    }
} 