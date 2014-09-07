<?php namespace Portico\Task\Http\Controller\Admin\Project;

use Controller, Redirect;
use Portico\Task\Project\Project;

class Delete extends Controller
{
    public function delete(Project $project)
    {
        $project->delete();

        return Redirect::route('admin.project.index')->with('notification', 'Project successfully deleted');
    }
} 