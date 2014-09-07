<?php namespace Portico\Task\Http\Controller;

use Controller;
use Portico\Task\Application\ApplicationRepository;

class Install extends Controller
{
    /** @var \Portico\Task\Application\ApplicationRepository  */
    protected $appRepo;

    public function __construct(ApplicationRepository $appRepo)
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