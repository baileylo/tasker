<?php namespace Portico\Task\UserStream;

interface UserStreamRepository
{
    /**
     * Get a paginated list
     *
     * @param int $userId   The id of the user to constrain the results by
     * @param int $pageSize The number of items to fetch
     *
     * @return UserStream[]
     */
    public function paginatedList($userId, $pageSize);
} 