<?php namespace spec\Portico\Task\Project;

use PhpSpec\ObjectBehavior;
use Portico\Task\Project\Project;
use Prophecy\Argument;

class PresenterSpec extends ObjectBehavior
{
    function let()
    {
        $project = new Project();
        $project->description =
            'This string is over the limit length, so we can make sure truncation';
        $this->beConstructedWith($project);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Portico\Task\Project\Presenter');
    }

    function it_should_truncate_the_description()
    {
        $this->shortDescription()->shouldBeLike('This string is over the limit length, so we can ma...');
    }
}