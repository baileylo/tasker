<?php namespace Task\Controller\Admin\Project;

use Controller, Input, Redirect, View;
use Task\Model\Project;
use Task\Service\Validator\Project\Validator;

class Edit extends Controller
{
    protected $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function show(Project $project)
    {
        return View::make('admin.project.edit', compact('project'));
    }

    public function handle(Project $project)
    {
        $data = Input::only(['description', 'name']);

        if ($errors = $this->validator->getErrors($data)) {
            return Redirect::back()->withInput()->withErrors($errors);
        }

        $project->description = $data['description'];
        $project->name = $data['name'];
        $project->save();

        return Redirect::route('admin.project.index');
    }
} 