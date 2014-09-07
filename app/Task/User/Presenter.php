<?php namespace Portico\Task\User;

use Portico\Core\Gravatar\GravatarGenerator;
use Portico\Core\Presenter\AbstractPresenter;

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
        return GravatarGenerator::get($this->model->email, $width);
    }
} 