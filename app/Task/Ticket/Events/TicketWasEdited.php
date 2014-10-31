<?php namespace Task\Task\Ticket\Events;

use Portico\Task\Ticket\Ticket;

class TicketWasEdited
{

    /** @var Ticket */
    private $ticket;

    function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * @return Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }
}