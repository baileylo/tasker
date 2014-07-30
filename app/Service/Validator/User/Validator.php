<?php namespace Task\Service\Validator\User;

use Illuminate\Validation\Factory;
use Task\Service\Validator\ValidatorInterface;

class Validator implements ValidatorInterface
{
    /** @var \Illuminate\Validation\Factory  */
    protected $factory;

    protected $rules = [
        'first_name' => 'required|min:2|max:255',
        'last_name' => 'required|min:2|max:255',
        'email' => 'required|email|unique:users'
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