<?php namespace Portico\Task\UserStream\Repository;

use Portico\Task\UserStream\UserStreamRepository;
use Portico\Task\UserStream\UserStream;

class Eloquent implements UserStreamRepository
{
    /** @var UserStream  */
    private $orm;

    public function __construct(UserStream $orm)
    {
        $this->orm = $orm;
    }

    /**
     * Get a paginated list
     * @param int $userId   The id of the user to constrain the results by
     * @param int $pageSize The number of items to fetch
     * @return UserStream[]
     */
    public function paginatedList($userId, $pageSize)
    {
        return $this->orm
            ->whereUserId($userId)
            ->simplePaginate($pageSize);
    }
}