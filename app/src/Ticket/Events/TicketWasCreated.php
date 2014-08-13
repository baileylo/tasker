<?php namespace Task\Ticket\Events;

use Task\Model\Ticket;

class TicketWasCreated
{
    /** @var \Task\Model\Ticket */
    protected $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * @return \Task\Model\Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }


} 