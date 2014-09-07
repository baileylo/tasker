<?php namespace Portico\Task\Ticket\Command;

use Illuminate\Validation\Factory;
use Portico\Task\Ticket\Enum\Type;
use Task\Service\Enum\LaravelValidatorBridge;
use Task\Service\Validator\ValidationFailedException;

class CreateTicketValidator
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

    public function validate(CreateTicketCommand $command)
    {
        $validator = $this->factory->make($command->toArray(), $this->rules);

        if ($validator->passes()) {
            return true;
        }

        throw new ValidationFailedException($validator->messages());
    }
} 