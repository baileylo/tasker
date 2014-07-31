<?php namespace Task\Controller;

use Controller, App, Task\Model\Application;
use Illuminate\Database\QueryException;
use Task\Model\Application\RepositoryInterface as AppRepo;

class Install extends Controller
{
    /** @var \Task\Model\Application\RepositoryInterface  */
    protected $appRepo;

    public function __construct(AppRepo $appRepo)
    {
        $this->appRepo = $appRepo;
    }

    public function message()
    {
        if ($this->appRepo->tableExists() && $this->appRepo->findSettings()->isAlreadySetup()) {
            App::abort(404);
        }

        return 'Please run <code>php artisan install</code> from the command line.';
    }
} 