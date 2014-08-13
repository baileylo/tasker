<?php namespace Task\Model;

use Carbon\Carbon;
use Eloquent;
use Laracasts\Commander\Events\EventGenerator;
use Task\Model\Ticket\Status;
use Task\Service\Presenter\Presentable;
use Task\Ticket\CreateTicketCommand;
use Task\Ticket\Events\TicketWasCreated;
use Task\Ticket\TicketFactory;

/**
 * Task\Model\Ticket
 *
 * @property-read \Task\Model\User $reporter
 * @property-read \Task\Model\Project $project
 * @property-read \Task\Model\User $assignee
 * @property-read \Illuminate\Database\Eloquent\Collection|\Task\Model\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\Task\Model\User[] $watchers
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $type
 * @property integer $reporter_id
 * @property integer $assignee_id
 * @property integer $project_id
 * @property \Carbon\Carbon $due_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $status
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\Ticket whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\Ticket whereName($value) 
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\Ticket whereDescription($value) 
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\Ticket whereType($value) 
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\Ticket whereReporterId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\Ticket whereProjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\Ticket whereAssigneeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\Ticket whereDueAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\Ticket whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\Ticket whereUpdatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\Ticket whereStatus($value) 
 */
class Ticket extends Eloquent
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
    protected $presenterName = 'Task\Model\Ticket\Presenter';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reporter()
    {
        return $this->belongsTo('Task\Model\User', 'reporter_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignee()
    {
        return $this->belongsTo('Task\Model\User', 'assignee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo('Task\Model\Project');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('Task\Model\Comment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function watchers()
    {
        return $this->belongsToMany('Task\Model\User', 'user_tickets');
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

} 