<?php namespace Task\Model\Application;

use Task\Model\Application;

class EloquentRepository implements RepositoryInterface
{
    /** @var \Task\Model\Application  */
    protected $orm;

    function __construct(Application $orm)
    {
        $this->orm = $orm;
    }

    public function findSettings()
    {
        return $this->orm->first()?: new Application();
    }
} 