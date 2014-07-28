<?php namespace Task\Model\Ticket;

use Task\Model\Ticket;

interface RepositoryInterface
{
    /**
     * @param int       $ticketId
     * @param string[]  $relationships
     *
     * @return Ticket|Null
     */
    public function findById($ticketId, array $relationships = []);
} 