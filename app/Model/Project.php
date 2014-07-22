<?php namespace Task\Model;

use Eloquent;
use Task\Service\Presenter\Presentable;

/**
 * Task\Model\Project
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Task\Model\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\Task\Model\Ticket[] $tickets
 */
class Project extends Eloquent
{
    use Presentable;

    protected $presenterName = 'Task\Model\Project\Presenter';

    protected $table = 'projects';

    public function users()
    {
        return $this->belongsToMany('Task\Model\User', 'user_projects');
    }

    public function tickets()
    {
        return $this->hasMany('Task\Model\Ticket');
    }
} 