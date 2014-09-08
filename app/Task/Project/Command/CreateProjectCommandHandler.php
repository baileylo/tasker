<?php namespace Portico\Task\Project\Command;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Portico\Task\Project\Project;

class CreateProjectCommandHandler implements CommandHandler
{
    use DispatchableTrait;

    /**
     * @param CreateProjectCommand $command
     * @return Project
     */
    public function handle($command)
    {
        $project = Project::createProject($command);

        $this->dispatchEventsFor($project);

        return $project;
    }

}