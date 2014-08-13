<?php namespace Task\Controller\User;

use Controller, View, Redirect, Session, Input, Auth;
use Task\Model\User;
use Task\Model\Project\RepositoryInterface as ProjectRepo;

class Project extends Controller
{

    /** @var \Task\Model\Project\RepositoryInterface  */
    protected $projectRepo;

    public function __construct(ProjectRepo $projectRepo)
    {
        $this->projectRepo = $projectRepo;
    }

    public function show()
    {
        $projects = $this->projectRepo->findAll();


        return View::make('user.projects', compact('projects'));
    }

    public function handle()
    {
        $data = Input::only(['first_name', 'last_name', 'email']);

        if ($errors = $this->validator->getErrors($data)) {
            return Redirect::back()->withInput()->withErrors($errors);
        }

        $user = new User();
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->save();

        Session::forget('email');

        return Redirect::route('home')->with('notification', 'Thank you for registering!');
    }
} 