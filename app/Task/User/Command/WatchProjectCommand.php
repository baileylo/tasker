<?php namespace Portico\Task\User\Command;

use Portico\Task\Project\Project;
use Portico\Task\User\User;

class WatchProjectCommand
{
    /** @var User */
    private $user;

    /** @var Project */
    private $project;

    /**
     * @param User $user
     * @param Project $project
     */
    public function __construct(User $user, Project $project)
    {
        $this->user = $user;
        $this->project = $project;
    }

    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}