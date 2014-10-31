<?php namespace Portico\Task\Ticket\Command;

use Illuminate\Validation\Factory;
use Portico\Core\Enum\LaravelValidatorBridge;
use Portico\Core\Validator\ValidationFailedException;
use Portico\Core\Validator\Validator;
use Portico\Task\Ticket\Enum\Status;
use Portico\Task\Ticket\Enum\Type;

class EditTicketValidator
{
    /** @var \Illuminate\Validation\Factory  */
    protected $factory;

    protected $rules = [
        'name' => 'required|min:2|max:255',
        'description' => 'required|min:20',
        'assignee_id' => 'exists:users,id',
        'status' => '', // Defined in constructor
        'type' => '', // Defined in constructor
        'due_date' => 'date_format:Y-m-d',
        'comment' => ''
    ];

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
        $statusBridge = new LaravelValidatorBridge(Status::readable());
        $this->rules['status'] = ['required', $statusBridge->getRule()];

        $typeBridge = new LaravelValidatorBridge(Type::readable());
        $this->rules['type'] = ['required', $typeBridge->getRule()];
    }

    public function validate(EditTicketCommand $command)
    {
        $validator = $this->factory->make($command->validationArray(), $this->rules);

        if ($validator->passes()) {
            return true;
        }

        throw new ValidationFailedException($validator->messages());
    }
} 