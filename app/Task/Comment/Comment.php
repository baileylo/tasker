<?php namespace Portico\Task\Comment;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Query\Builder;
use Portico\Task\Ticket\Ticket;
use Portico\Task\User\User;

/**
 * Task\Model\Comment
 *
 * @property-read \Portico\Task\User\User       $author
 * @property-read \Portico\Task\Ticket\Ticket   $ticket
 * @property integer                            $id
 * @property integer                            $author_id
 * @property string                             $message
 * @property integer                            $ticket_id
 * @property \Carbon\Carbon                     $created_at
 * @property \Carbon\Carbon                     $updated_at
 * @method static Builder|Comment whereId($value)
 * @method static Builder|Comment whereAuthorId($value)
 * @method static Builder|Comment whereMessage($value)
 * @method static Builder|Comment whereTicketId($value)
 * @method static Builder|Comment whereCreatedAt($value)
 * @method static Builder|Comment whereUpdatedAt($value)
 */
class Comment extends Eloquent
{
    protected $table = 'comments';

    public function author()
    {
        return $this->belongsTo('Portico\Task\User\User', 'author_id');
    }

    public function ticket()
    {
        return $this->belongsTo('Portico\Task\Ticket\Ticket');
    }

    public function setAuthor(User $author)
    {
        $this->author()->associate($author);
    }

    public function setTicket(Ticket $ticket)
    {
        $this->ticket()->associate($ticket);
    }
}