<?php

namespace spec\Portico\Task\Project\Events;

use PhpSpec\ObjectBehavior;
use Portico\Task\Project\Project;
use Prophecy\Argument;

class ProjectWasCreatedSpec extends ObjectBehavior
{
    public function let(Project $project)
    {
        $this->beConstructedWith($project);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Portico\Task\Project\Events\ProjectWasCreated');
    }

    function it_should_have_a_project(Project $project)
    {
        $this->getProject()->shouldReturn($project);
    }
}
