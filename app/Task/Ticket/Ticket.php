<?php namespace Portico\Task\Ticket;

use Eloquent;
use Laracasts\Commander\Events\EventGenerator;
use Portico\Task\Ticket\Enum\Status;
use Portico\Core\Presenter\Presentable;
use Portico\Task\Ticket\Command\CreateTicketCommand;
use Portico\Task\Ticket\Events\TicketWasCreated;

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
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\Ticket\Ticket whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\Ticket\Ticket whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\Ticket\Ticket whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\Ticket\Ticket whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\Ticket\Ticket whereReporterId($value)
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\Ticket\Ticket whereProjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\Ticket\Ticket whereAssigneeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\Ticket\Ticket whereDueAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\Ticket\Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\Ticket\Ticket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\Ticket\Ticket whereStatus($value)
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

} 