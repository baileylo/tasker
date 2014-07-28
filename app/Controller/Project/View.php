<?php namespace Task\Controller\Project;

use Controller, View as Template;
use Task\Model\Project;

class View extends Controller
{
    public function show(Project $project)
    {
        return Template::make('project.show', compact('project'));
    }
} 