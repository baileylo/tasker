<?php namespace Portico\Task\Project\Command;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\Events\EventDispatcher;
use Portico\Task\Project\Project;
use Portico\Task\Project\ProjectFactory;

class CreateProjectCommandHandler implements CommandHandler
{
    use DispatchableTrait;

    /** @var EventDispatcher  */
    protected $dispatcher;
    /**
     * @var ProjectFactory
     */
    private $factory;

    public function __construct(EventDispatcher $dispatcher, ProjectFactory $factory)
    {
        $this->dispatcher = $dispatcher;
        $this->factory = $factory;
    }

    /**
     * @return EventDispatcher
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * @param CreateProjectCommand $command
     * @return Project
     */
    public function handle($command)
    {
        $project = $this->factory->makeFromCommand($command);

        $project->saveNewProject();

        $this->dispatchEventsFor($project);

        return $project;
    }

}