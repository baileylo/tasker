<?php namespace Task\Model\Ticket;

use Task\Model\Ticket;
use Task\Service\Presenter\AbstractPresenter;

class Presenter extends AbstractPresenter
{
    /** @var \Task\Model\Ticket $model */

    public function __construct(Ticket $model)
    {
        $this->model = $model;
    }

    public function status()
    {
        return Status::readable()[$this->model->status];
    }
} 