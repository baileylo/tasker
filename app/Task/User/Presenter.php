<?php namespace Portico\Task\User;

use Task\Service\Gravatar;
use Task\Service\Presenter\AbstractPresenter;

class Presenter extends AbstractPresenter
{
    /** @var User $model */

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function full_name()
    {
        return $this->model->first_name . ' ' . $this->model->last_name;
    }

    public function gravatar_url($width = 50)
    {
        return Gravatar::get($this->model->email, $width);
    }
} 