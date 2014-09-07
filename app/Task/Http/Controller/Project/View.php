<?php namespace Portico\Task\Http\Controller\Project;

use Controller, View as Template;
use Portico\Task\Project\Project;
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
        $open = $this->ticketRepository->findProjectsMostRecentOpenTickets($project->id);
        $closed = $this->ticketRepository->findsProjectsMostRecentClosedTickets($project->id);
        $upcoming = $this->ticketRepository->findProjectsOpenTicketsDueSoon($project->id);

        return Template::make('project.show', compact('project', 'open', 'closed', 'upcoming'));
    }
} 