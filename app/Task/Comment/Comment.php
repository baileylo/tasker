<?php namespace Portico\Task\Comment;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Task\Model\Comment
 *
 * @property-read \Portico\Task\User\User       $author
 * @property-read \Portico\Task\Ticket\Ticket   $ticket
 * @property integer        $id
 * @property integer        $author_id
 * @property string         $message
 * @property integer        $ticket_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\Comment\Comment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\Comment\Comment whereAuthorId($value)
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\Comment\Comment whereMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\Comment\Comment whereTicketId($value)
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\Comment\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\Comment\Comment whereUpdatedAt($value)
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
} 