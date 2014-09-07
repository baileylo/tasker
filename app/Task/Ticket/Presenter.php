<?php namespace Portico\Task\Ticket;

use Portico\Task\Ticket\Enum\Status;
use Task\Service\Presenter\AbstractPresenter;

class Presenter extends AbstractPresenter
{
    /** @var \Portico\Task\Ticket\Ticket $model */

    public function __construct(Ticket $model)
    {
        $this->model = $model;
    }

    public function status()
    {
        return Status::readable()[$this->model->status];
    }

    public function stream_name()
    {
        return "{$this->model->project->name}/Ticket#{$this->model->id}";
    }
} 