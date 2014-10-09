<?php

namespace spec\Portico\Task\Project\Listeners;

use Illuminate\Database\Connection;
use PhpSpec\ObjectBehavior;
use Portico\Core\PhpSpec\Relatable;
use Portico\Task\Project\Project;
use Portico\Task\Ticket\Events\TicketWasCreated;
use Portico\Task\Ticket\Ticket;
use Portico\Task\User\User;
use Prophecy\Argument;
use Portico\Task\Project\Listeners\WatcherListener;

class WatcherListenerSpec extends ObjectBehavior
{
    use Relatable;

    public function let(Connection $connection)
    {
        $this->relate($connection);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(WatcherListener::class);
    }

    protected function build_ticket(Project $project)
    {
        $ticket = new Ticket();
        $ticket->setProject($project->getWrappedObject());
        $ticket->setReporter(new User);
        $ticket->removeAssignee();

        return $ticket;
    }

    function it_should_attach_the_reporter(Project $project)
    {
        $ticket = $this->build_ticket($project);

        $project->addWatcher($ticket->reporter)->shouldBeCalled();

        $this->whenTicketWasCreated(new TicketWasCreated($ticket));
    }

    function it_should_attach_the_assignee(Project $project)
    {
        $ticket = $this->build_ticket($project);
        $ticket->setAssignee(new User);

        $project->addWatcher($ticket->reporter)->shouldBeCalled();
        $project->addWatcher($ticket->assignee)->shouldBeCalled();

        $this->whenTicketWasCreated(new TicketWasCreated($ticket));
    }
}
