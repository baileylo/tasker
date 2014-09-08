<?php namespace Portico\Core\Validator;

interface Validator
{
    /**
     * @param array $input
     * @return Boolean|\Illuminate\Support\MessageBag
     */
    public function getErrors(array $input);
} 