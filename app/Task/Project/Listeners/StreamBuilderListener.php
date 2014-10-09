<?php namespace Portico\Task\Project\Listeners;

use Laracasts\Commander\Events\EventListener;
use Portico\Task\Ticket\Events\TicketWasCreated;
use Portico\Task\Ticket\Ticket;
use Portico\Task\User\User;
use Portico\Task\UserStream\UserStream;
use Portico\Task\UserStream\UserStreamFactory;

class StreamBuilderListener extends EventListener
{
    /** @var UserStreamFactory */
    private $streamFactory;

    public function __construct(UserStreamFactory $streamFactory)
    {
        $this->streamFactory = $streamFactory;
    }

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

        foreach($watchers as $user) {
            $streamEntry = $this->streamFactory->make($user, $ticket, UserStream::TYPE_TICKET_CREATED);
            $streamEntry->save();
        }
    }
} 