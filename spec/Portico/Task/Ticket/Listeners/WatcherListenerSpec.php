<?php namespace spec\Portico\Task\Ticket\Listeners;

use Illuminate\Database\Connection;
use PhpSpec\ObjectBehavior;
use Portico\Core\PhpSpec\Relatable;
use Portico\Task\Ticket\Listeners\WatcherListener;
use Portico\Task\Ticket\Ticket;
use Portico\Task\User\User;
use Prophecy\Argument;

class WatcherListenerSpec extends ObjectBehavior
{
    use Relatable;

    function let(Connection $conn)
    {
        $this->relate($conn);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(WatcherListener::class);
    }

    private function build_ticket($includeAssignee = false)
    {
        $ticket = new Ticket;

        $reporter = new User();
        $reporter->id = 8;
        $ticket->setReporter($reporter);

        if (!$includeAssignee) {
            return $ticket;
        }

        $assignee = new User();
        $assignee->id = 32;
        $ticket->setAssignee($assignee);
    }

    function it_should_attach_the_reporter()
    {
        $ticket = $this->build_ticket();

        $ticket->addWatcher($ticket->reporter)->shouldBeCalled();

        $this->whenTicketWasCreated(new TicketWasCreated($ticket));
    }

//    function it_should_attach_the_assignee(Project $project)
//    {
//        $ticket = $this->build_ticket($project);
//        $ticket->setAssignee(new User);
//
//        $project->addWatcher($ticket->reporter)->shouldBeCalled();
//        $project->addWatcher($ticket->assignee)->shouldBeCalled();
//
//        $this->whenTicketWasCreated(new TicketWasCreated($ticket));
//    }
} 