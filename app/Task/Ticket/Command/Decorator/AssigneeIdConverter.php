<?php namespace Portico\Task\Ticket\Command\Decorator;

use Portico\Task\Ticket\Command\EditTicketCommand;
use Portico\Task\User\UserRepository;
use Laracasts\Commander\CommandBus;

/**
 * Converts an email to a user account.
 */
class AssigneeIdConverter implements CommandBus
{

    /** @var UserRepository */
    private $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * @param EditTicketCommand $command
     * @return mixed|void
     */
    public function execute($command)
    {
        $user = $this->userRepo->findById($command->getAssigneeId());
        if ($user) {
            $command->setAssignee($user);
        }
    }
}