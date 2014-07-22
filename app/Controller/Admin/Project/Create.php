<?php namespace Task\Controller\Admin\Project;

use Controller, View, Redirect, Input, Auth;
use Task\Model\Project;
use Task\Service\Notification;
use Task\Service\Validator\Project\Validator;

class Create extends Controller
{

    protected $validator;

    protected $wildCard;

    public function __construct(Validator $validator, Notification\WildCard $wildCard)
    {
        $this->validator = $validator;
        $this->wildCard = $wildCard;
    }

    public function view()
    {
        return View::make('admin.project.create');
    }

    public function handle()
    {
        $data = Input::only(['description', 'name']);

        if ($errors = $this->validator->getErrors($data)) {
            return Redirect::back()->withInput()->withErrors($errors);
        }

        $project = new Project();
        $project->name = $data['name'];
        $project->description = $data['description'];
        $project->save();

        $project->users()->save(Auth::user());

        $notification = new Notification\Notification(
            'Project %s was successfully created',
            [$this->wildCard->make($project->name, 'em')]
        );

        return Redirect::to('admin')->with('notification', $notification);
    }
} 