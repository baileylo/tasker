<?php namespace Portico\Task\Project\Command;

use Illuminate\Validation\Factory;
use Portico\Core\Validator\ValidationFailedException;
use Portico\Core\Validator\Validator;

class CreateProjectValidator implements Validator
{
    /** @var \Illuminate\Validation\Factory  */
    protected $factory;

    protected $rules = [
        'name' => 'required|min:2|max:255',
        'description' => 'required|min:20'
    ];

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function validate(CreateProjectCommand $command)
    {
        $validator = $this->factory->make([
            'name' => $command->getName(),
            'description' => $command->getDescription()
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