<?php namespace Portico\Task\Project;

use Portico\Task\Project\Command\CreateProjectCommand;

class ProjectFactory
{
    public function makeFromCommand(CreateProjectCommand $command)
    {
        $project = new Project();
        $project->name = $command->getName();
        $project->description = $command->getDescription();

        return $project;
    }
}
