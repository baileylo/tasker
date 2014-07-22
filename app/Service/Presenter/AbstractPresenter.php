<?php namespace Task\Service\Presenter;


abstract class AbstractPresenter
{

    /** @var \Eloquent */
    protected $model;

    public function __get($attribute)
    {
        if (!method_exists($this, $attribute)) {
            throw new Exception\InvalidMethodException('The '. get_called_class() . '::' . $attribute . ' method does not exist!');
        }

        return $this->{$attribute}();
    }
} 