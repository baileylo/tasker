<?php namespace spec\Portico\Task\Project\Listeners;

use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Collection;
use PhpSpec\ObjectBehavior;
use Portico\Core\PhpSpec\Relatable;
use Portico\Task\Project\Project;
use Portico\Task\Ticket\Events\TicketWasCreated;
use Portico\Task\Ticket\Ticket;
use Portico\Task\User\User;
use Portico\Task\UserStream\UserStream;
use Portico\Task\UserStream\UserStreamFactory;
use Prophecy\Argument;
use Portico\Task\Project\Listeners\StreamBuilderListener;

class StreamBuilderListenerSpec extends ObjectBehavior
{
    use Relatable;

    public function let(UserStreamFactory $streamFactory)
    {
        $this->beConstructedWith($streamFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(StreamBuilderListener::class);
    }

    function it_should_save_new_stream_entries(UserStreamFactory $streamFactory, UserStream $userStream, Connection $connection)
    {
        $this->relate($connection);

        $projectWatcher = new User;
        $project = new Project();
        $project->watchers = new Collection([$projectWatcher]);

        $ticket = new Ticket();
        $ticket->watchers = new Collection();
        $ticket->setProject($project);

        $streamFactory
            ->make($projectWatcher, $ticket, UserStream::TYPE_TICKET_CREATED)
            ->willReturn($userStream);

        $userStream->save()->shouldBeCalled();

        $this->whenTicketWasCreated(new TicketWasCreated($ticket));
    }
} 
