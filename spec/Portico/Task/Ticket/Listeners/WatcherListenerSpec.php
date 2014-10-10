<?php namespace spec\Portico\Task\Ticket\Listeners;

use Laracasts\Commander\Events\EventListener;
use PhpSpec\ObjectBehavior;
use Portico\Task\Ticket\Events\TicketWasCreated;
use Portico\Task\Ticket\Listeners\WatcherListener;
use Portico\Task\Ticket\Ticket;
use Portico\Task\User\User;
use Prophecy\Argument;

class WatcherListenerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(WatcherListener::class);
        $this->beAnInstanceOf(EventListener::class);
    }

    function it_should_attach_the_reporter(Ticket $ticket)
    {
        $ticket->getAttribute('reporter')->willReturn(new User);
        $ticket->getAttribute('assignee')->willReturn(null);

        $ticket->addWatcher($ticket->reporter)->shouldBeCalled();

        $this->whenTicketWasCreated(new TicketWasCreated($ticket->getWrappedObject()));
    }

    function it_should_attach_the_assignee(Ticket $ticket)
    {
        $ticket->getAttribute('reporter')->willReturn(new User);
        $ticket->getAttribute('assignee')->willReturn(new User);

        $ticket->addWatcher($ticket->reporter)->shouldBeCalled();
        $ticket->addWatcher($ticket->assignee)->shouldBeCalled();

        $this->whenTicketWasCreated(new TicketWasCreated($ticket->getWrappedObject()));
    }
} 