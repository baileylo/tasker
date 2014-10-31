<?php namespace Portico\Task\Http\Controller\Project;

use Controller;
use Portico\SessionUser\SessionUser;
use Portico\Task\Project\Project;

class Watch extends Controller
{
    /**
     * @var \Portico\Task\User\User
     */
    private $sessionUser;

    public function __construct(SessionUser $sessionUser)
    {

        $this->sessionUser = $sessionUser;
    }

    public function watch(Project $project)
    {
        $this->sessionUser->watchProject($project);
    }

    public function unwatch(Project $project)
    {
        $this->sessionUser->stopWatchingProject($project);
    }
} 