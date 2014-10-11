<?php namespace Portico\Task\Ticket;


interface TicketRepository
{
    /**
     * @param int       $ticketId
     * @param string[]  $relationships
     *
     * @return Ticket|Null
     */
    public function findById($ticketId, array $relationships = []);

    /**
     * Finds the newest tickets from all projects that a given user follows
     *
     * @param int   $userId
     * @param array $relationships
     * @return Ticket[]
     */
    public function findNewTicketsForProjectsFollowedByUser($userId, $limit);

    /**
     * Finds the newest tickets from all projects that a given user follows
     *
     * @param int   $userId
     * @param array $relationships
     * @return Ticket[]
     */
    public function findRecentlyUpdatedTicketsForProjectsFollowedByUser($userId, $limit);
} 