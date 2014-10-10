<?php namespace Portico\Task\User\Command;

use Illuminate\Validation\Factory;
use Portico\Core\Validator\Validator;

class CreateUserValidator implements Validator
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

    public function validate(CreateUserCommand $command)
    {
        $validator = $this->factory->make([
            'first_name' => $command->getFirstName(),
            'last_name' => $command->getLastName(),
            'email' => $command->getEmail()
        ], $this->rules);

        if ($validator->passes()) {
            return true;
        }

        throw new ValidationFailedException($validator->messages());
    }

    public function getErrors(array $input)
    {
        $validator = $this->factory->make($input, $this->rules);

        return $validator->fails() ? $validator->messages() : false;
    }
} 