<?php namespace Task\Model\Ticket;

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
} 