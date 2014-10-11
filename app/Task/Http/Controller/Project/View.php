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
        $open = $this->ticketRepository->findProjectsMostRecentOpenTickets($project->id, 5);
        $closed = $this->ticketRepository->findsProjectsMostRecentClosedTickets($project->id, 5);
        $upcoming = $this->ticketRepository->findProjectsOpenTicketsDueSoon($project->id, 5);

        $openIssueCount = $this->ticketRepository->countProjectsOpenIssues($project->id);
        $closedIssueCount = $this->ticketRepository->countProjectsClosedIssues($project->id);

        // Open Tickets
        // This might want to be moved into a repository?
        $tickets = $project->tickets()
            ->whereRaw('(tickets.status & ?) = ' . Status::OPEN, [Status::OPEN])
            ->with(['commentCount', 'reporter'])
            ->orderBy('tickets.created_at')
            ->paginate(15);

        return Template::make('project.show', compact('project', 'open', 'closed', 'upcoming', 'openIssueCount', 'closedIssueCount', 'tickets'));
    }
} 