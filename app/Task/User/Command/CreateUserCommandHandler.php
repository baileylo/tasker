<?php namespace Portico\Task\User\Command;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Portico\Task\User\User;

class CreateUserCommandHandler implements CommandHandler
{
    use DispatchableTrait;

    /**
     * Handle the command
     *
     * @param CreateUserCommand $command
     * @return mixed
     */
    public function handle($command)
    {
        $user = User::createUser($command);

        $this->dispatchEventsFor($user);

        return $user;
    }
}