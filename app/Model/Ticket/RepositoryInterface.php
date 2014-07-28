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

    /**
     * Finds the most recent tickets that are associated with open tickets
     *
     * @param int       $projectId
     * @param string[]  $relationships
     *
     * @return Ticket[]
     */
    public function findProjectsMostRecentOpenTickets($projectId, array $relationships = []);

    /**
     * Finds the tickets with the closest deadline.
     *
     * @param int       $projectId
     * @param string[]  $relationships
     *
     * @return Ticket[]
     */
    public function findProjectsOpenTicketsDueSoon($projectId, array $relationships = []);

    /**
     * Finds the tickets that have been closed most recently
     *
     * @param int       $projectId
     * @param string[]  $relationships
     *
     * @return Ticket[]
     */
    public function findsProjectsMostRecentClosedTickets($projectId, array $relationships = []);
} 