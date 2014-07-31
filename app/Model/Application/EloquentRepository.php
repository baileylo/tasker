<?php namespace Task\Model\Application;

use Illuminate\Database\QueryException;
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
        return $this->orm->first() ?: new Application();
    }

    /**
     * Determine if the database table exists.
     *
     * @return bool
     */
    public function tableExists()
    {
        try {
            Application::first();

            return true;
        }

        catch(QueryException $e) {
            return false;
        }
    }
} 