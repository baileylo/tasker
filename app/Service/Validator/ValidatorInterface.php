<?php namespace Task\Service\Validator;

interface ValidatorInterface
{
    /**
     * @param array $input
     * @return Boolean|\Illuminate\Support\MessageBag
     */
    public function getErrors(array $input);
} 