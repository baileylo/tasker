<?php namespace Portico\Task\Project;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Laracasts\Commander\Events\EventGenerator;
use Portico\Core\Presenter\Presentable;
use Portico\Task\Project\Events\ProjectWasCreated;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Portico\Task\Ticket\Enum\Status;
use Portico\Task\User\User;

/**
 * Portico\Task\Project\Project
 *
 * @property-read Collection|\Portico\Task\Ticket\Ticket[] $tickets
 * @property-read Collection|\Portico\Task\User\User[] $watchers
 * @property-read Collection|\Portico\Task\Ticket\Ticket[] $openTickets
 * @property-read Collection|\Portico\Task\Ticket\Ticket[] $closedTickets
 * @property-read int $open_ticket_count
 * @property-read int $closed_ticket_count
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function openTickets()
    {
        return $this->tickets()
            ->whereRaw('(status & ?) = '. intval(Status::OPEN), [Status::OPEN]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function openTicketCount()
    {
        return $this->openTickets()->selectRaw('project_id, count(*) as count')->groupBy('project_id')->limit(1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function closedTickets()
    {
        return $this->tickets()
            ->whereRaw('(status & ?) = '. intval(Status::CLOSED), [Status::CLOSED]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function closedTicketCount()
    {
        return $this->closedTickets()->selectRaw('project_id, count(*) as count')->groupBy('project_id')->limit(1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function watchers()
    {
        return $this->belongsToMany('Portico\Task\User\User', 'user_projects');
    }

    public function getOpenTicketCountAttribute()
    {
        if (!isset($this->getRelations()['openTicketCount'])) {
            // Load the openTicketCount relationship.
            $this->getRelationshipFromMethod('openTicketCount', 'openTicketCount');
        }

        if ($this->getRelation('openTicketCount')->first()) {
            return intval($this->getRelation('openTicketCount')->first()->count);
        }

        return 0;
    }

    public function getClosedTicketCountAttribute()
    {
        if (!isset($this->getRelations()['closedTicketCount'])) {
            // Load the openTicketCount relationship.
            $this->getRelationshipFromMethod('closedTicketCount', 'closedTicketCount');
        }

        if ($this->getRelation('closedTicketCount')->first()) {
            return intval($this->getRelation('closedTicketCount')->first()->count);
        }

        return 0;
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