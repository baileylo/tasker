<?php namespace Portico\Task\Http\Controller\Admin\Project;

use Controller, View;
use Portico\Task\Project\ProjectRepository;

class Overview extends Controller
{

    /**
     * @var ProjectRepository
     */
    protected $projectRepo;

    public function __construct(ProjectRepository $projectRepo)
    {
        $this->projectRepo = $projectRepo;
    }

    public function index()
    {
        $projects = $this->projectRepo->findAll();

        return View::make('admin.project.index', compact('projects'));
    }
} 