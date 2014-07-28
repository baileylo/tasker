<?php namespace Task\Controller\Project;

use Controller, View as Template;
use Task\Model\Project;
use Task\Model\Ticket\RepositoryInterface as TicketRepo;

class View extends Controller
{
    protected $ticketRepo;

    public function __construct(TicketRepo $ticketRepo)
    {
        $this->ticketRepo = $ticketRepo;
    }

    public function show(Project $project)
    {
        $open = $this->ticketRepo->findProjectsMostRecentOpenTickets($project->id);
        $closed = $this->ticketRepo->findsProjectsMostRecentClosedTickets($project->id);
        $upcoming = $this->ticketRepo->findProjectsOpenTicketsDueSoon($project->id);

        return Template::make('project.show', compact('project', 'open', 'closed', 'upcoming'));
    }
} 