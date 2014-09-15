<?php namespace Portico\Task\Project\Listeners;

use Laracasts\Commander\Events\EventListener;
use Portico\Task\Ticket\Events\TicketWasCreated;
use Portico\Task\UserStream\UserStream;

class StreamBuilderListener extends EventListener
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

        // Combine watchers from project and ticket, though this really shouldn't matter.
        $watchers = $project->watchers->merge($ticket->watchers);
        if ($ticket->assignee) {
            $watchers->add($ticket->assignee);
        }

        $watchers->add($ticket->reporter);
        if ($ticket->reporter) {
            $watchers->add($ticket->reporter);
        }



        foreach($watchers as $user) {
            $this->createStreamEntry($user->id, $ticket->id);
        }
    }

    protected function createStreamEntry($userId, $ticketId)
    {
        $streamEntry = new UserStream();
        $streamEntry->user_id = $userId;
        $streamEntry->object_id = $ticketId;
        $streamEntry->type = UserStream::TYPE_TICKET_CREATED;
        $streamEntry->save();

        return $streamEntry;
    }
} 