<?php namespace Task\Model;

use Eloquent;
use Task\Service\Presenter\Presentable;

/**
 * Task\Model\Project
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Task\Model\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\Task\Model\Ticket[] $tickets
 * @property-read \Illuminate\Database\Eloquent\Collection|\Task\Model\User[] $watchers
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\Project whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\Project whereName($value) 
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\Project whereDescription($value) 
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\Project whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\Project whereUpdatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\Project whereDeletedAt($value) 
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function watchers()
    {
        return $this->belongsToMany('Task\Model\User', 'user_projects');
    }
} 