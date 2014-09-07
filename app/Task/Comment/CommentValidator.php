<?php namespace Portico\Task\Validator\Comment;

use Illuminate\Validation\Factory;
use Portico\Core\Validator\Validator;

class CommentValidator implements Validator
{
    /** @var \Illuminate\Validation\Factory  */
    protected $factory;

    protected $rules = [
        'comment' => 'required|min:20'
    ];

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function getErrors(array $input)
    {
        $validator = $this->factory->make($input, $this->rules);

        return $validator->fails() ? $validator->messages() : false;
    }
} 