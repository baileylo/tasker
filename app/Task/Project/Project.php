<?php namespace Portico\Task\Project;

use Eloquent;
use Task\Service\Presenter\Presentable;

/**
 * Portico\Task\Project\Project
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Portico\Task\User\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\Portico\Task\Ticket\Ticket[] $tickets
 * @property-read \Illuminate\Database\Eloquent\Collection|\Portico\Task\User\User[] $watchers
 * @property integer        $id
 * @property string         $name
 * @property string         $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string         $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\Project\Project whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\Project\Project whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\Project\Project whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\Project\Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\Project\Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\Project\Project whereDeletedAt($value)
 */
class Project extends Eloquent
{
    use Presentable;

    protected $presenterName = 'Portico\Task\Project\Presenter';

    protected $table = 'projects';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany('Portico\Task\Ticket\Ticket');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function watchers()
    {
        return $this->belongsToMany('Portico\Task\User\User', 'user_projects');
    }
} 