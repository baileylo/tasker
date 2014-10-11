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
     * Finds the most recent tickets that are associated with open tickets
     *
     * @param int       $projectId
     * @param string[]  $relationships
     * @param int       $limit
     *
     * @return Ticket[]
     */
    public function findProjectsMostRecentOpenTickets($projectId, $limit, array $relationships = []);

    /**
     * Finds the tickets with the closest deadline.
     *
     * @param int       $projectId
     * @param string[]  $relationships
     * @param int       $limit
     *
     * @return Ticket[]
     */
    public function findProjectsOpenTicketsDueSoon($projectId, $limit, array $relationships = []);

    /**
     * Finds the tickets that have been closed most recently
     *
     * @param int       $projectId
     * @param string[]  $relationships
     * @param int       $limit
     *
     * @return Ticket[]
     */
    public function findsProjectsMostRecentClosedTickets($projectId, $limit, array $relationships = []);

    /**
     * Number of open issues in a project
     *
     * @param int $projectId
     *
     * @return mixed
     */
    public function countProjectsOpenIssues($projectId);

    /**
     * Number of closed issues in a project
     *
     * @param int $projectId
     *
     * @return int
     */
    public function countProjectsClosedIssues($projectId);

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