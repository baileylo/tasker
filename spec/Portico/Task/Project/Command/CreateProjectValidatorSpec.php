<?php

namespace spec\Portico\Task\Project\Command;

use Illuminate\Support\MessageBag;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;
use PhpSpec\ObjectBehavior;
use Portico\Task\Project\Command\CreateProjectCommand;
use Prophecy\Argument;

class CreateProjectValidatorSpec extends ObjectBehavior
{
    protected $rules;

    function let(Factory $factory)
    {
        $this->beConstructedWith($factory);
        $this->rules = [
            'name' => 'required|min:2|max:255',
            'description' => 'required|min:20'
        ];
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Portico\Task\Project\Command\CreateProjectValidator');
    }

    function it_should_translate_command_into_an_array(Factory $factory, Validator $validator)
    {
        $command = new CreateProjectCommand('foo', 'bar');
        $factory->make(['description' => 'bar', 'name' => 'foo'], $this->rules)->willReturn($validator);
        $validator->passes()->willReturn(true);
        $this->validate($command);
    }

    function it_should_throw_exception_when_validation_fails(Factory $factory, Validator $validator)
    {
        $factory->make(Argument::any(), $this->rules)->willReturn($validator);
        $validator->messages()->willReturn(new MessageBag());
        $validator->passes()->willReturn(false);
        $this->shouldThrow('Portico\Core\Validator\ValidationFailedException')->during('validate', [new CreateProjectCommand('foo', 'bar')]);
    }

    function it_should_return_true_when_validate_data_is_used(Factory $factory, Validator $validator)
    {
        $factory->make(Argument::any(), $this->rules)->willReturn($validator);
        $validator->passes()->willReturn(true);
        $this->validate(new CreateProjectCommand('', ''))->shouldBeEqualTo(true);
    }

    function it_should_allow_direct_access_to_error_messages(Factory $factory, Validator $validator)
    {
        $factory->make(Argument::any(), $this->rules)->willReturn($validator);
        $validator->fails()->willReturn(true);
        $validator->messages()->willReturn($messages = new MessageBag());
        $this->getErrors([])->shouldBe($messages);
    }

    function it_should_return_false_on_valid_data(Factory $factory, Validator $validator)
    {
        $factory->make(Argument::any(), $this->rules)->willReturn($validator);
        $validator->fails()->willReturn(false);
        $this->getErrors([])->shouldBe(false);
    }

    function it_should_pass_input_to_factory(Factory $factory, Validator $validator)
    {
        $input = ['name' => 'foo', 'description' => 'bar'];
        $factory->make($input, $this->rules)->willReturn($validator);
        $validator->fails()->willReturn(false);
        $this->getErrors($input);
    }

}
