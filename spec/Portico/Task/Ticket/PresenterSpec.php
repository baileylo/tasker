<?php namespace spec\Portico\Task\Ticket;


use PhpSpec\ObjectBehavior;
use Portico\Task\Project\Project;
use Portico\Task\Ticket\Enum\Status;
use Portico\Task\Ticket\Ticket;
use Prophecy\Argument;

/**
 * @method string stream_name
 * @method string status
 */
class PresenterSpec extends ObjectBehavior
{
    /** @var Ticket */
    protected $ticket;

    function let()
    {
        $ticket = new Ticket();
        $ticket->status = Status::POSTPONED;
        $ticket->id = 182;

        $project = new Project();
        $project->name = 'Spec Test';
        $ticket->setProject($project);

        $this->beConstructedWith($ticket);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Portico\Task\Ticket\Presenter');
    }

    function it_should_build_a_readable_status()
    {
        $this->status()->shouldBe('Postponed');
    }

    function it_should_build_a_stream_name()
    {
        $this->stream_name()->shouldBe('Spec Test/Ticket#182');
    }
} 
