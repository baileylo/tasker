<?php namespace Portico\Task\Project\Listeners;

use Portico\Task\Ticket\Events\TicketWasCreated;

class WatcherListener
{
    /**
     * When a ticket is created, the reporter and assignee, if present, are made
     * watchers of the project.
     *
     * @param TicketWasCreated $event
     */
    public function whenTicketWasCreated(TicketWasCreated $event)
    {
        $ticket = $event->getTicket();
        $project = $ticket->project;

        $project->addWatcher($ticket->reporter);

        if ($ticket->assignee) {
            $project->addWatcher($ticket->assignee);
        }
    }
} 