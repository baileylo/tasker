<?php namespace Portico\Task\Project;

use Illuminate\Support\Str;
use Portico\Core\Presenter\AbstractPresenter;

class Presenter extends AbstractPresenter
{
    /** @var \Portico\Task\Project\Project $model */

    public function __construct(Project $model)
    {
        $this->model = $model;
    }

    public function shortDescription()
    {
        return Str::limit($this->model->description, 50);
    }
} 