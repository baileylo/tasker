<?php namespace Task\Model\Ticket;

use string;
use Task\Model\Ticket;

class EloquentRepository implements RepositoryInterface
{
    /**
     * @var \Task\Model\Ticket
     */
    protected $orm;

    public function __construct(Ticket $project)
    {
        $this->orm = $project;
    }

    /**
     * @param int $ticketId
     * @param string[] $relationships
     *
     * @return Ticket|Null
     */
    public function findById($ticketId, array $relationships = [])
    {
        return $this->orm->with($relationships)->find(intval($ticketId));
    }

    private function getQueryForProjectsTicketsAndStatus($status, $projectId, $relationships)
    {
        return $this->orm->with($relationships)
            ->whereProjectId($projectId)
            // Status is not passed in as a parameter here a second time, because it will be bound as a string and
            // in some databases this will cause incorrect comparisons(sqlite)
            ->whereRaw('(status & ?) = ' . intval($status), [$status]);
    }

    /**
     * Finds the most recent tickets that are associated with open tickets
     *
     * @param int $projectId
     * @param string[] $relationships
     *
     * @return Ticket[]
     */
    public function findProjectsMostRecentOpenTickets($projectId, array $relationships = [])
    {
        return $this->getQueryForProjectsTicketsAndStatus(Status::OPEN, intval($projectId), $relationships)
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    /**
     * Finds the tickets with the closest deadline.
     *
     * @param int $projectId
     * @param string[] $relationships
     *
     * @return Ticket[]
     */
    public function findProjectsOpenTicketsDueSoon($projectId, array $relationships = [])
    {
        return $this->getQueryForProjectsTicketsAndStatus(Status::OPEN, intval($projectId), $relationships)
            ->whereNotNull('due_at')
            ->orderBy('due_at', 'asc')
            ->get();
    }

    /**
     * Finds the tickets that have been closed most recently
     *
     * @param int $projectId
     * @param string[] $relationships
     *
     * @return Ticket[]
     */
    public function findsProjectsMostRecentClosedTickets($projectId, array $relationships = [])
    {
        return $this->orm->with($relationships)
            ->whereProjectId($projectId)
            ->whereRaw('(status & 8) = 0')
            ->orderBy('updated_at', 'desc')
            ->get();
    }
} 