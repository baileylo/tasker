<?php namespace Task\Ticket;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Task\Model\Ticket;

class CreateTicketCommandHandler implements CommandHandler
{
    use DispatchableTrait;

    /**
     * @param CreateTicketCommand $command
     * @return mixed|void
     */
    public function handle($command)
    {
        $ticket = Ticket::createTicket($command);

        $this->dispatchEventsFor($ticket);

        return $ticket;
    }

}