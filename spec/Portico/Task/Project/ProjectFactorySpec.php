<?php

namespace spec\Portico\Task\Project;

use PhpSpec\ObjectBehavior;
use Portico\Task\Project\Command\CreateProjectCommand;
use Portico\Task\Project\Project;
use Prophecy\Argument;

class ProjectFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Portico\Task\Project\ProjectFactory');
    }

    function it_should_make_a_project_from_command()
    {
        $this
            ->makeFromCommand(new CreateProjectCommand('foo', 'bar'))
            ->shouldReturnAnInstanceOf('Portico\Task\Project\Project');
    }

    function it_should_populate_project_fields()
    {
        $project = new Project();
        $project->name = 'foo';
        $project->description = 'bar';

        $command = new CreateProjectCommand($project->name, $project->description);

        $this->makeFromCommand($command)->shouldBeLike($project);
    }
}
