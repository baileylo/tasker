<?php namespace Task\Service\Validator\Ticket;

use Illuminate\Validation\Factory;
use Task\Service\Validator\Comment\Validator;
use Task\Model\Ticket\Status;
use Task\Service\Enum\LaravelValidatorBridge;

class Close extends Validator
{
    /** @var \Illuminate\Validation\Factory  */
    protected $factory;

    public function __construct(Factory $factory)
    {
        parent::__construct($factory);

        $bridge = new LaravelValidatorBridge(Status::readableClosed());

        $this->rules['status'] = ['required', $bridge->getRule()];
    }

    public function getErrors(array $input)
    {
        $validator = $this->factory->make($input, $this->rules);

        return $validator->fails() ? $validator->messages() : false;
    }
} 