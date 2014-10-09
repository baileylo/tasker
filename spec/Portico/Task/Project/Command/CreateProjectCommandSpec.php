<?php

namespace spec\Portico\Task\Project\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreateProjectCommandSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('my new project', 'a really interesting project description');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Portico\Task\Project\Command\CreateProjectCommand');
    }

    function it_should_provide_access_to_description()
    {
        $this->getDescription()->shouldBeEqualTo('a really interesting project description');
    }

    function it_should_provide_access_to_name()
    {
        $this->getName()->shouldBeEqualTo('my new project');
    }
}
