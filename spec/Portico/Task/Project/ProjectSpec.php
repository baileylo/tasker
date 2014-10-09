<?php namespace spec\Portico\Task\Project;

use Illuminate\Database\Connection;
use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Grammars\MySqlGrammar;
use Illuminate\Database\Query\Processors\MySqlProcessor;
use PhpSpec\ObjectBehavior;
use Portico\Core\PhpSpec\EloquentMatcher;
use Portico\Task\Project\Events\ProjectWasCreated;
use Portico\Task\Project\Project;
use Portico\Task\User\User;
use Prophecy\Argument;

/**
 *
 * @property-read Collection|\Portico\Task\Ticket\Ticket[] $tickets
 * @property-read Collection|\Portico\Task\User\User[] $watchers
 * @property integer        $id
 * @property string         $name
 * @property string         $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string         $deleted_at
 * @method null watchers
 * @method Project getWrappedObject
 *
 * @package spec\Portico\Task\Project
 */
class ProjectSpec extends ObjectBehavior
{
    use EloquentMatcher;

    function let(Connection $connection)
    {
        $this->id = 23;
        $this->name = 'Test Project';
        $this->description = 'A sample project';

        $connection->getQueryGrammar()->willReturn(new MySqlGrammar());
        $connection->getPostProcessor()->willReturn(new MySqlProcessor());

        $this->setConnectionResolver($connection);
    }

    function setConnectionResolver($connection)
    {
        $connectionResolver = new ConnectionResolver(['mine' => $connection->getWrappedObject()]);
        $connectionResolver->setDefaultConnection('mine');
        Project::setConnectionResolver($connectionResolver);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Portico\Task\Project\Project');
    }

    function it_should_have_tickets()
    {
        $this->tickets()->shouldDefineRelationship('HasMany', 'Portico\Task\Ticket\Ticket');
    }

    function it_should_have_watchers()
    {
        $this->watchers()->shouldDefineRelationship('belongsToMany', 'Portico\Task\User\User');
    }

    function it_should_allow_the_addition_of_watchers(Connection $connection)
    {
        $user = new User;
        $user->id = 15;

        $connection->insert(Argument::any(), [$this->id, $user->id])->shouldBeCalled();
        $this->setConnectionResolver($connection);

        $this->watchers = new Collection();

        $this->addWatcher($user)->shouldBe(true);

        $this->watchers->shouldHaveCount(1);
    }

    function it_should_prevent_double_addition_of_watchers()
    {
        $user = new User;
        $user->id = 15;

        $this->watchers = new Collection([$user]);

        $this->addWatcher($user)->shouldBe(false);

        $this->watchers->shouldHaveCount(1);
    }

    function it_should_save_new_projects(Connection $connection, \PDO $pdo)
    {
        $connection->insert(Argument::type('string'), Argument::that(function($queryParameters) {
            if ($queryParameters[0] != $this->id->getWrappedObject()) return false;
            if ($queryParameters[1] != $this->name->getWrappedObject()) return false;
            if ($queryParameters[2] != $this->description->getWrappedObject()) return false;

            // Now we're going to do some fuzzy date search
            $passedDate = new \DateTime($queryParameters[3]);
            $difference = $passedDate->diff(new \DateTime);
            if ($difference->s > 5) return false;

            // Now we're going to do some fuzzy date search
            $passedDate = new \DateTime($queryParameters[4]);
            $difference = $passedDate->diff(new \DateTime);
            if ($difference->s > 5) return false;

            return true;
        }))->shouldBeCalled();
        $connection->getPdo()->willReturn($pdo);
        $pdo->lastInsertId("id")->willReturn($this->id);
        $this->setConnectionResolver($connection);

        $this->saveNewProject();
        $this->releaseEvents()->shouldBeLike([new ProjectWasCreated($this->getWrappedObject())]);
    }
} 