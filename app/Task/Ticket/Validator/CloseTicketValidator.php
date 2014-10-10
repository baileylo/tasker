<?php namespace Portico\Task\Ticket\Validator;

use Illuminate\Validation\Factory;
use Portico\Core\Enum\LaravelValidatorBridge;
use Portico\Task\Comment\CommentValidator;
use Portico\Task\Ticket\Enum\Status;

class CloseTicketValidator extends CommentValidator
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