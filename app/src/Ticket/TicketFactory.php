<?php namespace Task\Ticket;

use Task\Model\Ticket;

class TicketFactory
{
    /**
     * @param CreateTicketCommand $command
     * @return Ticket
     */
    public function makeFromCommand(CreateTicketCommand $command)
    {
        $ticket = new Ticket();
        $ticket->reporter()->associate($command->getCreator());
        $ticket->project()->associate($command->getProject());
        $ticket->description = $command->getDescription();
        $ticket->name = $command->getName();
        $ticket->type = intval($command->getType());
        $ticket->status = Ticket\Status::WAITING;

        if ($command->getDueDate()) {
            $ticket->due_at = $command->getDueDate();
        }

        if ($command->getAssignee()) {
            $ticket->assignee()->associate($command->getAssignee());
        }

        return $ticket;
    }
} 