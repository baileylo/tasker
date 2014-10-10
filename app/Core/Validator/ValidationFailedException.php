<?php namespace Portico\Core\Validator;

use Illuminate\Support\MessageBag;

class ValidationFailedException extends \Exception
{
    /**
     * @var MessageBag
     */
    private $errors;

    public function __construct(MessageBag $errors = null) {

        $this->errors = $errors;
    }

    /**
     * @return MessageBag
     */
    public function getErrors()
    {
        return $this->errors;
    }
} 