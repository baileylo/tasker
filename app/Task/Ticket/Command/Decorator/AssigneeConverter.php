<?php namespace Portico\Task\Ticket\Command\Decorator;

use Portico\Task\Ticket\Command\CreateTicketCommand;
use Portico\Task\User\UserRepository;
use Laracasts\Commander\CommandBus;

/**
 * Converts an email to a user account.
 */
class AssigneeConverter implements CommandBus
{

    /** @var UserRepository */
    private $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * @param CreateTicketCommand $command
     * @return mixed|void
     */
    public function execute($command)
    {
        $user = $this->userRepo->findByEmail($command->getAssigneeEmailAddress());
        if ($user) {
            $command->setAssignee($user);
        }
    }
}