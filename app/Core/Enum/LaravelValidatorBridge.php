<?php namespace Portico\Core\Enum;


class LaravelValidatorBridge
{
    protected $enumValues;

    public function __construct($enumHash)
    {
        $this->enumValues = $enumHash;
    }

    public function getRule()
    {
        return 'in:' . implode(',', array_keys($this->enumValues));
    }
} 