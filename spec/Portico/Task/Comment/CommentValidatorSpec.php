<?php

namespace spec\Portico\Task\Comment;

use Illuminate\Validation\Factory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Portico\Task\Comment\CommentValidator;

class CommentValidatorSpec extends ObjectBehavior
{
    function let(Factory $factory)
    {
        $this->beConstructedWith($factory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CommentValidator::class);
    }
}
