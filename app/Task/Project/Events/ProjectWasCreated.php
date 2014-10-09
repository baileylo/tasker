<?php namespace Portico\Task\Project\Events;

use Portico\Task\Project\Project;

class ProjectWasCreated
{
    /**
     * @var Project
     */
    private $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }
} 