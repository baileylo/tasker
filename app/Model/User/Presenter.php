<?php namespace Task\Model\User;

use Task\Model\User;
use Task\Service\Presenter\AbstractPresenter;

class Presenter extends AbstractPresenter
{
    /** @var \Task\Model\User $model */

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function full_name()
    {
        return $this->model->first_name . ' ' . $this->model->last_name;
    }
} 