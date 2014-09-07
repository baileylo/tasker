<?php namespace Portico\Task\Project;

use Illuminate\Validation\Factory;
use Portico\Core\Validator\Validator;

class ProjectValidator implements Validator
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

    public function getErrors(array $input)
    {
        $validator = $this->factory->make($input, $this->rules);

        return $validator->fails() ? $validator->messages() : false;
    }
} 