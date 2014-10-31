<?php namespace Portico\Task\Ticket;

use Portico\Task\Ticket\Enum\Status;
use Portico\Core\Presenter\AbstractPresenter;
use Portico\Task\Ticket\Enum\Type;

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

    public function general_status()
    {
        return $this->model->isOpen() ? 'Open' : 'Closed';
    }

    public function stream_name()
    {
        return "{$this->model->project->name}/Ticket#{$this->model->id}";
    }

    public function type()
    {
        return Type::readable()[$this->model->type];
    }
} 
