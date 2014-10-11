<?php namespace Portico\Task\Ticket\Repository;

use Illuminate\Database\Eloquent\Builder;
use Portico\Task\Ticket\Enum\Status;
use Portico\Task\Ticket\TicketRepository;
use Portico\Task\Ticket\Ticket;

class Eloquent implements TicketRepository
{
    /**
     * @var Ticket
     */
    protected $orm;

    public function __construct(Ticket $project)
    {
        $this->orm = $project;
    }

    /**
     * @param int      $ticketId
     * @param string[] $relationships
     *
     * @return Ticket|Null
     */
    public function findById($ticketId, array $relationships = [])
    {
        return $this->orm->with($relationships)->find(intval($ticketId));
    }

    /**
     * Prepares a query which will return all tickets from projects that a given user follows.
     *
     * @param int $userId
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function findTicketsWatchedByProject($userId)
    {
        $projectRelationship = $this->orm->project();
        $project = [
            'table' => $projectRelationship->getRelated()->getTable(),
            'key' => $projectRelationship->getQualifiedOtherKeyName(),
            'foreign' => $projectRelationship->getQualifiedForeignKey()
        ];

        /** @var \Illuminate\Database\Eloquent\Relations\BelongsToMany $projectWatchersRelationship */
        $projectWatchersRelationship = $this->orm->project()->getRelated()->watchers();

        $userProjects = [
            'table' => $projectWatchersRelationship->getTable(),
            'key' => $projectWatchersRelationship->getForeignKey(),
            'foreign' => $projectWatchersRelationship->getParent()->getQualifiedKeyName()
        ];

        return $this->orm
            ->join($project['table'], $project['key'], '=', $project['foreign'])
            ->join($userProjects['table'], $userProjects['key'], '=', $userProjects['foreign'])
            ->select("{$this->orm->getTable()}.*")
            ->where($projectWatchersRelationship->getOtherKey(), '=', $userId);
    }

    /**
     * Finds the newest tickets from all projects that a given user follows
     *
     * @param int   $userId
     * @param int   $limit
     *
     * @return Ticket[]
     */
    public function findNewTicketsForProjectsFollowedByUser($userId, $limit)
    {
        return $this->findTicketsWatchedByProject($userId)
            ->orderBy("{$this->orm->getTable()}.created_at", 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Finds the most recently update tickets from all projects that a given user follows
     *
     * @param int   $userId
     * @param array $relationships
     *
     * @return Ticket[]
     */
    public function findRecentlyUpdatedTicketsForProjectsFollowedByUser($userId, $limit, array $relationships = [])
    {
        return $this->findTicketsWatchedByProject($userId)
            ->orderBy("{$this->orm->getTable()}.updated_at", 'desc')
            ->limit($limit)
            ->get();
    }
}