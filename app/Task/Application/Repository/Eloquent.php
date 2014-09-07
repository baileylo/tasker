<?php namespace Portico\Task\Application\Repository;

use Illuminate\Database\QueryException;
use Portico\Task\Application;

class Eloquent implements Application\ApplicationRepository
{
    /** @var \Portico\Task\Application\Application  */
    protected $orm;

    function __construct(Application\Application $orm)
    {
        $this->orm = $orm;
    }

    public function findSettings()
    {
        return $this->orm->first() ?: new Application\Application();
    }

    /**
     * Determine if the database table exists.
     *
     * @return bool
     */
    public function tableExists()
    {
        try {
            Application\Application::first();

            return true;
        }

        catch(QueryException $e) {
            return false;
        }
    }
} 