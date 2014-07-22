<?php namespace Task\Controller\Admin\Project;

use Controller, Redirect;
use Task\Model\Project;

class Delete extends Controller
{
    public function delete(Project $project)
    {
        $project->delete();

        return Redirect::route('admin.project.index')->with('notification', 'Project successfully deleted');
    }
} 