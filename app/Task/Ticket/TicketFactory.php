<?php namespace Portico\Task\Ticket;

use Portico\Task\Ticket\Command\CreateTicketCommand;
use Portico\Task\Ticket\Enum\Status;

class TicketFactory
{
    /**
     * @param CreateTicketCommand $command
     * @return Ticket
     */
    public function makeFromCommand(CreateTicketCommand $command)
    {
        $ticket = new Ticket();
        $ticket->setProject($command->getProject());
        $ticket->setReporter($command->getCreator());

        if ($command->getAssignee()) {
            $ticket->setAssignee($command->getAssignee());
        }

        $ticket->description = $command->getDescription();
        $ticket->name = $command->getName();
        $ticket->type = intval($command->getType());
        $ticket->status = Status::WAITING;

        if ($command->getDueDate()) {
            $ticket->due_at = $command->getDueDate();
        }

        return $ticket;
    }
} 