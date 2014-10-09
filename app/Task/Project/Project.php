<?php namespace Portico\Task\Project;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Laracasts\Commander\Events\EventGenerator;
use Portico\Core\Presenter\Presentable;
use Portico\Task\Project\Command\CreateProjectCommand;
use Portico\Task\Project\Events\ProjectWasCreated;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Portico\Task\User\User;

/**
 * Portico\Task\Project\Project
 *
 * @property-read Collection|\Portico\Task\Ticket\Ticket[] $tickets
 * @property-read Collection|\Portico\Task\User\User[] $watchers
 * @property integer        $id
 * @property string         $name
 * @property string         $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string         $deleted_at
 * @method static Builder|Project whereId($value)
 * @method static Builder|Project whereName($value)
 * @method static Builder|Project whereDescription($value)
 * @method static Builder|Project whereCreatedAt($value)
 * @method static Builder|Project whereUpdatedAt($value)
 * @method static Builder|Project whereDeletedAt($value)
 */
class Project extends Eloquent
{
    use Presentable;
    use EventGenerator;

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

    /**
     * Adds a watcher if the watcher does not already exist.
     *
     * @param User $user User to become follower
     *
     * @return Boolean true if the user was added, false if the user is already watching
     */
    public function addWatcher(User $user)
    {
        if ($this->watchers->contains($user)) {
            return false;
        }

        $this->watchers()->attach($user);
        $this->watchers->add($user);

        return true;
    }

    /**
     * Creates a Saves the passed supplied project and raises events
     *
     * @return Project
     */
    public function saveNewProject()
    {
        $this->raise(new ProjectWasCreated($this));

        $this->save();
    }


} 