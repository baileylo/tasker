<?php

namespace spec\Portico\Task\Project\Command;

use Laracasts\Commander\Events\EventDispatcher;
use PhpSpec\ObjectBehavior;
use Portico\Task\Project\Command\CreateProjectCommand;
use Portico\Task\Project\Events\ProjectWasCreated;
use Portico\Task\Project\Project;
use Portico\Task\Project\ProjectFactory;
use Prophecy\Argument;

class CreateProjectCommandHandlerSpec extends ObjectBehavior
{
    function let(EventDispatcher $dispatcher, ProjectFactory $factory)
    {
        $this->beConstructedWith($dispatcher, $factory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Portico\Task\Project\Command\CreateProjectCommandHandler');
    }

    function it_should_allow_access_to_dispatcher(EventDispatcher $dispatcher)
    {
        $this->getDispatcher()->shouldBeEqualTo($dispatcher);
    }

    function it_should_create_a_project_using_the_factory(EventDispatcher $dispatcher, ProjectFactory $factory, Project $project)
    {
        $command = new CreateProjectCommand('foo', 'bar');
        $factory->makeFromCommand($command)->willReturn($project);
        $project->saveNewProject()->shouldBeCalled();
        $project->releaseEvents()->willReturn([]);

        $dispatcher->dispatch(Argument::any());
        $this->handle($command);
    }

    function it_should_release_projects_events(EventDispatcher $dispatcher, ProjectFactory $factory, Project $project, ProjectWasCreated $event)
    {
        $factory->makeFromCommand(Argument::any())->willReturn($project);
        $project->saveNewProject()->shouldBeCalled();

        $project->releaseEvents()->willReturn([$event]);
        $dispatcher->dispatch([$event])->shouldBeCalled();

        $this->handle(new CreateProjectCommand('foo', 'bar'));
    }

    function it_should_return_new_project(EventDispatcher $dispatcher, ProjectFactory $factory, Project $project)
    {
        $command = new CreateProjectCommand('foo', 'bar');
        $factory->makeFromCommand($command)->willReturn($project);
        $project->saveNewProject()->shouldBeCalled();
        $project->releaseEvents()->willReturn([]);

        $dispatcher->dispatch(Argument::any());
        $this->handle(new CreateProjectCommand('foo', 'bar'))->shouldBe($project);
    }

}
