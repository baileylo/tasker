<?php namespace Portico\Task\Http\Controller\User;

use Controller, View;
use Portico\Task\Project\ProjectRepository;

class Project extends Controller
{

    /** @var \Portico\Task\Project\ProjectRepository  */
    protected $projectRepo;

    public function __construct(ProjectRepository $projectRepo)
    {
        $this->projectRepo = $projectRepo;
    }

    public function show()
    {
        $projects = $this->projectRepo->findAll();


        return View::make('user.projects', compact('projects'));
    }
} 