<?php namespace Task\Model\Project;

use Illuminate\Support\Str;
use Task\Model\Project;
use Task\Service\Presenter\AbstractPresenter;

class Presenter extends AbstractPresenter
{
    /** @var \Task\Model\Project $model */

    public function __construct(Project $model)
    {
        $this->model = $model;
    }

    public function shortDescription()
    {
        return Str::limit($this->model->description, 50);
    }
} 