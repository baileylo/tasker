<?php namespace Portico\Task\User\Command;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class WatchProjectCommandHandler implements CommandHandler
{
    use DispatchableTrait;

    /**
     * Handle the command
     *
     * @param WatchProjectCommand $command
     * @return mixed
     */
    public function handle($command)
    {
        $command->getUser()->watchProject($command->getProject());

        $this->dispatchEventsFor($command->getUser());
    }
}