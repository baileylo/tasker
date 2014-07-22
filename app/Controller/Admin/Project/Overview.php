<?php namespace Task\Controller\Admin\Project;

use Controller, View;
use Task\Model\Project\RepositoryInterface;

class Overview extends Controller
{

    /**
     * @var RepositoryInterface
     */
    protected $projectRepo;

    public function __construct(RepositoryInterface $projectRepo)
    {
        $this->projectRepo = $projectRepo;
    }

    public function index()
    {
        $projects = $this->projectRepo->findAll();

        return View::make('admin.project.index', compact('projects'));
    }
} 