<?php namespace spec\Portico\Task\Ticket;

use Illuminate\Database\Connection;
use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Grammars\MySqlGrammar;
use Illuminate\Database\Query\Processors\MySqlProcessor;
use PhpSpec\ObjectBehavior;
use Portico\Core\PhpSpec\EloquentMatcher;
use Portico\Task\Project\Project;
use Portico\Task\Ticket\Enum\Status;
use Portico\Task\Ticket\Enum\Type;
use Portico\Task\Ticket\Ticket;
use Portico\Task\User\User;
use Prophecy\Argument;

/**
 * Task\Model\Ticket
 *
 * @property-read \Portico\Task\User\User       $reporter
 * @property-read \Portico\Task\Project\Project $project
 * @property-read \Portico\Task\User\User       $assignee
 * @property-read \Illuminate\Database\Eloquent\Collection|\Portico\Task\Comment\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\Portico\Task\User\User[]        $watchers
 * @property integer        $id
 * @property string         $name
 * @property string         $description
 * @property integer        $type
 * @property integer        $reporter_id
 * @property integer        $assignee_id
 * @property integer        $project_id
 * @property \Carbon\Carbon $due_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer        $status
 */
class TicketSpec extends ObjectBehavior
{
    use EloquentMatcher;

    function let(Connection $connection)
    {
        $this->id = 54;
        $this->name = 'Something is broken';
        $this->description = 'When I do something, it doesn\'t work how it should.';
        $this->type = Type::BUG;
        $this->status = Status::OPEN;

        $connection->getQueryGrammar()->willReturn(new MySqlGrammar());
        $connection->getPostProcessor()->willReturn(new MySqlProcessor());

        $this->setConnectionResolver($connection);
    }

    function setConnectionResolver($connection)
    {
        $connectionResolver = new ConnectionResolver(['mine' => $connection->getWrappedObject()]);
        $connectionResolver->setDefaultConnection('mine');
        Ticket::setConnectionResolver($connectionResolver);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Portico\Task\Ticket\Ticket');
    }

    function it_should_have_a_reporter()
    {
        $this->reporter()->shouldDefineRelationship('belongsTo', 'Portico\Task\User\User');
    }

    function it_should_have_an_assignee()
    {
        $this->assignee()->shouldDefineRelationship('belongsTo', 'Portico\Task\User\User');
    }

    function it_should_have_a_project()
    {
        $this->project()->shouldDefineRelationship('belongsTo', 'Portico\Task\Project\Project');
    }

    function it_should_have_comments()
    {
        $this->comments()->shouldDefineRelationship('hasMany', 'Portico\Task\Comment\Comment');
    }

    function it_should_have_watchers()
    {
        $this->watchers()->shouldDefineRelationship('belongsToMany', 'Portico\Task\User\User');
    }

    function it_should_have_3_date_fields()
    {
        $this->getDates()->shouldBe(['created_at', 'updated_at', 'due_at']);
    }

    function it_should_register_status_as_closed()
    {
        $this->status = Status::SOLVED;
        $this->shouldNotBeOpen();
        $this->shouldBeClosed();

        $this->status = Status::WONT_FIX;
        $this->shouldNotBeOpen();
        $this->shouldBeClosed();

        $this->status = Status::DUPLICATE;
        $this->shouldNotBeOpen();
        $this->shouldBeClosed();
    }

    function it_should_register_status_as_open()
    {
        $this->status = Status::REVIEW;
        $this->shouldBeOpen();
        $this->shouldNotBeClosed();

        $this->status = Status::REVIEW_REQUIRED;
        $this->shouldBeOpen();
        $this->shouldNotBeClosed();

        $this->status = Status::POSTPONED;
        $this->shouldBeOpen();
        $this->shouldNotBeClosed();

        $this->status = Status::PROGRESS;
        $this->shouldBeOpen();
        $this->shouldNotBeClosed();

        $this->status = Status::WAITING;
        $this->shouldBeOpen();
        $this->shouldNotBeClosed();
    }

    function it_should_be_able_to_change_projects()
    {
        $project = new Project();
        $project->id = 12;

        $this->setProject($project);

        $this->project->shouldBe($project);
        $this->project_id->shouldBe($project->id);
    }

    function it_should_be_able_to_change_reporters()
    {
        $reporter = new User();
        $reporter->id = 38;

        $this->setReporter($reporter);

        $this->reporter->shouldBe($reporter);
        $this->reporter_id->shouldBe($reporter->id);
    }

    function it_should_be_able_to_change_assignee()
    {
        $assignee = new User;
        $assignee->id = 8;

        $this->setAssignee($assignee);

        $this->assignee->shouldBe($assignee);
        $this->assignee_id->shouldBe($assignee->id);
    }

    function it_should_be_able_to_remove_assignee()
    {
        $assignee = new User;
        $assignee->id = 8;

        $this->setAssignee($assignee);
        $this->removeAssignee();

        $this->assignee->shouldBe(null);
        $this->assignee_id->shouldBe(null);
    }

    function it_should_throw_an_exception_if_there_is_no_id()
    {
        $this->id = null;
        $this->shouldThrow('\Exception')->duringGetStreamId();
    }

    function it_should_return_id()
    {
        $this->getStreamId()->shouldBe($this->id);
    }

    function it_should_prevent_the_double_addition_of_watchers()
    {
        $user = new User();
        $user->id = 6;

        $this->watchers = new Collection([$user]);
        $this->addWatcher($user)->shouldBe(false);
        $this->watchers->shouldHaveCount(1);
    }

    function it_should_allow_the_addition_of_watchers(Connection $connection)
    {
        $user = new User;
        $user->id = 15;

        $connection->insert(Argument::any(), [$this->id, $user->id])->shouldBeCalled();
        $this->setConnectionResolver($connection);

        $this->watchers = new Collection;
        $this->addWatcher($user)->shouldBe(true);
        $this->watchers->shouldHaveCount(1);
    }
}