<?php namespace spec\Portico\Task\Project;

use Illuminate\Support\MessageBag;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProjectValidatorSpec extends ObjectBehavior
{
    function let(Factory $factory, Validator $validator)
    {
        $factory->make(Argument::type('array'), Argument::type('array'))->willReturn($validator);

        $this->beConstructedWith($factory);
    }

    function it_should_return_false_if_there_are_no_errors(Validator $validator)
    {
        $validator->fails()->willReturn(false);

        $this->getErrors([])->shouldBe(false);
    }

    function it_should_return_all_error_messages(Validator $validator)
    {
        $messages = new MessageBag();
        $validator->fails()->willReturn(true);
        $validator->messages()->willReturn($messages);

        $this->getErrors([])->shouldReturn($messages);
    }

} 