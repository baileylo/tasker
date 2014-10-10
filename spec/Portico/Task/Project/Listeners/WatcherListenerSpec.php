<?php

namespace spec\Portico\Task\Project\Listeners;

use Laracasts\Commander\Events\EventListener;
use PhpSpec\ObjectBehavior;
use Portico\Task\Project\Project;
use Portico\Task\Ticket\Events\TicketWasCreated;
use Portico\Task\Ticket\Ticket;
use Portico\Task\User\User;
use Prophecy\Argument;
use Portico\Task\Project\Listeners\WatcherListener;

class WatcherListenerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(WatcherListener::class);
        $this->beAnInstanceOf(EventListener::class);
    }

    function it_should_attach_the_reporter(Project $project, Ticket $ticket)
    {
        $ticket->getAttribute('project')->willReturn($project);
        $ticket->getAttribute('reporter')->willReturn(new User);
        $ticket->getAttribute('assignee')->willReturn(false);

        $project->addWatcher($ticket->reporter)->shouldBeCalled();

        $this->whenTicketWasCreated(new TicketWasCreated($ticket->getWrappedObject()));
    }

    function it_should_attach_the_assignee(Project $project, Ticket $ticket)
    {
        $ticket->getAttribute('project')->willReturn($project);
        $ticket->getAttribute('reporter')->willReturn(new User);
        $ticket->getAttribute('assignee')->willReturn(new User);

        $project->addWatcher($ticket->reporter)->shouldBeCalled();
        $project->addWatcher($ticket->assignee)->shouldBeCalled();

        $this->whenTicketWasCreated(new TicketWasCreated($ticket->getWrappedObject()));
    }
}
