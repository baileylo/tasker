<?php namespace Portico\Task\Ticket;

use Illuminate\Database\Query\Builder;
use Laracasts\Commander\Events\EventGenerator;
use Portico\Task\Project\Project;
use Portico\Task\Ticket\Enum\Status;
use Portico\Core\Presenter\Presentable;
use Portico\Task\Ticket\Command\CreateTicketCommand;
use Portico\Task\Ticket\Events\TicketWasCreated;
use Portico\Task\User\User;
use Portico\Task\UserStream\StreamItem;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Task\Model\Ticket
 *
 * @property-read \Portico\Task\User\User       $reporter
 * @property-read \Portico\Task\Project\Project $project
 * @property-read \Portico\Task\User\User       $assignee
 * @property-read \Illuminate\Database\Eloquent\Collection|\Portico\Task\Comment\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\Portico\Task\User\User[]        $watchers
 * @property integer        $id
 * @property string         $name
 * @property string         $description
 * @property integer        $type
 * @property integer        $reporter_id
 * @property integer        $assignee_id
 * @property integer        $project_id
 * @property \Carbon\Carbon $due_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer        $status
 * @method static Builder|Ticket whereId($value)
 * @method static Builder|Ticket whereName($value)
 * @method static Builder|Ticket whereDescription($value)
 * @method static Builder|Ticket whereType($value)
 * @method static Builder|Ticket whereReporterId($value)
 * @method static Builder|Ticket whereProjectId($value)
 * @method static Builder|Ticket whereAssigneeId($value)
 * @method static Builder|Ticket whereDueAt($value)
 * @method static Builder|Ticket whereCreatedAt($value)
 * @method static Builder|Ticket whereUpdatedAt($value)
 * @method static Builder|Ticket whereStatus($value)
 */
class Ticket extends Eloquent implements StreamItem
{
    use Presentable;
    use EventGenerator;

    /**
     * Name of the database table
     * @var string
     */
    protected $table = 'tickets';

    /**
     * Name of the class presenter;
     * @var string
     */
    protected $presenterName = 'Portico\Task\Ticket\Presenter';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reporter()
    {
        return $this->belongsTo('Portico\Task\User\User', 'reporter_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignee()
    {
        return $this->belongsTo('Portico\Task\User\User', 'assignee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo('Portico\Task\Project\Project');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('Portico\Task\Comment\Comment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function watchers()
    {
        return $this->belongsToMany('Portico\Task\User\User', 'user_tickets');
    }

    /**
     * All attributes that should be handled as dates.
     *
     * @return array
     */
    public function getDates()
    {
        return ['created_at', 'updated_at', 'due_at'];
    }


    /**
     * Determine if the status of a ticket is open
     *
     * @return bool
     */
    public function isOpen()
    {
        return boolval(intval($this->status) & Status::OPEN);
    }

    /**
     * Determine if the status of a ticket is closed
     *
     * @return bool
     */
    public function isClosed()
    {
        return !$this->isOpen();
    }

    public static function createTicket(CreateTicketCommand $command)
    {
        $factory = new TicketFactory();

        $ticket = $factory->makeFromCommand($command);
        $ticket->save();

        $ticket->raise(new TicketWasCreated($ticket));

        return $ticket;
    }

    public function setProject(Project $project)
    {
        $this->project()->associate($project);
    }

    public function setReporter(User $reporter)
    {
        $this->reporter()->associate($reporter);
    }

    public function setAssignee(User $assignee)
    {
        $this->assignee()->associate($assignee);
    }

    public function removeAssignee()
    {
        $this->assignee()->dissociate();
    }

    public function addWatcher(User $user)
    {
        if ($this->watchers->contains($user)) {
            return false;
        }

        $this->watchers()->attach($user->getKey());
        $this->watchers->add($user);

        return true;
    }

    /**
     * The UID of the stream item.
     *
     * @throws \Exception When the object has not been saved
     * @return int
     */
    public function getStreamId()
    {
        if (is_null($this->id)) {
            throw new \Exception('Attempting to access stream id of unsaved value.');
        }
        return $this->id;
    }
}