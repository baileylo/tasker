<?php namespace Task\Ticket;

use Task\Model\User\RepositoryInterface;
use Laracasts\Commander\CommandBus;

/**
 * Converts an email to a user account.
 * @package Task\Ticket
 */
class AssigneeConverter implements CommandBus
{

    /**
     * @var RepositoryInterface
     */
    private $userRepo;

    public function __construct(RepositoryInterface $userRepo)
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