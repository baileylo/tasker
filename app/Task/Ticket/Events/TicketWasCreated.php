<?php namespace Portico\Task\Ticket\Events;

use Portico\Task\Ticket\Ticket;

class TicketWasCreated
{
    /** @var Ticket */
    protected $ticket;

    public function __construct(Ticket $ticket)
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