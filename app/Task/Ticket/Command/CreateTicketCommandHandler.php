<?php namespace Portico\Task\Ticket\Command;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Portico\Task\Ticket\Ticket;

class CreateTicketCommandHandler implements CommandHandler
{
    use DispatchableTrait;

    /**
     * @param CreateTicketCommand $command
     * @return Ticket
     */
    public function handle($command)
    {
        $ticket = Ticket::createTicket($command);

        $this->dispatchEventsFor($ticket);

        return $ticket;
    }

}