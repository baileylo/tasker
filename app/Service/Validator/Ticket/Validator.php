<?php namespace Task\Service\Validator\Ticket;

use Illuminate\Validation\Factory;
use Task\Model\Ticket\Type;
use Task\Service\Enum\LaravelValidatorBridge;
use Task\Service\Validator\ValidatorInterface;

class Validator implements ValidatorInterface
{
    /** @var \Illuminate\Validation\Factory  */
    protected $factory;

    protected $rules = [
        'name' => 'required|min:2|max:255',
        'description' => 'required|min:20',
        'assignee' => 'email|exists:users,email',
        'due_date' => [],
        'type' => []
    ];

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;

        // Create Date Validator
        $this->rules['due_date'] = [
            'after:' . date('Y-m-d'),
            'date_format:Y-m-d'
        ];

        $bridge = new LaravelValidatorBridge(Type::readable());

        $this->rules['type'] = ['required', $bridge->getRule()];
    }

    public function getErrors(array $input)
    {
        $validator = $this->factory->make($input, $this->rules);

        return $validator->fails() ? $validator->messages() : false;
    }
} 