<?php namespace Task\Service\Validator\Comment;

use Illuminate\Validation\Factory;
use Task\Service\Validator\ValidatorInterface;

class Validator implements ValidatorInterface
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