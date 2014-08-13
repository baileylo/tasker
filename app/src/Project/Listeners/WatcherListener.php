<?php namespace Task\Project\Listeners;

use Laracasts\Commander\Events\EventListener;
use Task\Ticket\Events\TicketWasCreated;

class WatcherListener extends EventListener
{

    /**
     * Adds watchers upon ticket creation.
     *
     * @param TicketWasCreated $event
     */
    public function whenTicketWasCreated(TicketWasCreated $event)
    {
        $ticket = $event->getTicket();
        $project = $ticket->project;

        $watchers = [$ticket->reporter_id];

        // If the ticket is assigned to somebody, mark them as a watcher.
        if ($ticket->assignee_id) {
            $watchers[] = $ticket->assignee_id;
        }

        foreach(array_unique($watchers) as $userId) {
            $project->watcher()->attach($userId);
        }
    }
} 