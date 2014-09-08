<?php namespace Portico\Task\Project;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Laracasts\Commander\Events\EventGenerator;
use Portico\Core\Presenter\Presentable;
use Portico\Task\Project\Command\CreateProjectCommand;
use Portico\Task\Project\Events\ProjectWasCreated;
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
     * Creates a new project, saves a new projects, and raises ProjectWasCreated event.
     *
     * @param CreateProjectCommand $command
     * @return Project
     */
    public static function createProject(CreateProjectCommand $command)
    {
        $project = new Project();
        $project->name = $command->getName();
        $project->description = $command->getDescription();

        $project->raise(new ProjectWasCreated($project));

        $project->save();

        return $project;
    }
} 