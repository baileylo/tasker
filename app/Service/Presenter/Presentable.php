<?php namespace Task\Service\Presenter;

trait Presentable
{
    protected $presenter;

    public function present()
    {
        if (!is_null($this->presenter)) {
            return $this->presenter;
        }

        if (empty($this->presenterName)) {
            throw new Exception\UndefinedPresenterClassException('Must declare protected $presenterName when using Presentable');
        }

        if (!class_exists($this->presenterName)) {
            throw new Exception\InvalidPresenterClassException;
        }

        if (!isset($this->presenter)) {
            $this->presenter = new $this->presenterName($this);
        }

        return $this->presenter;
    }
} 