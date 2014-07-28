<?php namespace Task\Model;

use Eloquent;

/**
 * Task\Model\Comment
 *
 * @property-read \Task\Model\User $author
 * @property-read \Task\Model\Ticket $ticket
 * @property integer $id
 * @property integer $author_id
 * @property string $message
 * @property integer $ticket_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\Comment whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\Comment whereAuthorId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\Comment whereMessage($value) 
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\Comment whereTicketId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\Comment whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\Comment whereUpdatedAt($value) 
 */
class Comment extends Eloquent
{
    protected $table = 'comments';

    public function author()
    {
        return $this->belongsTo('Task\Model\User', 'author_id');
    }

    public function ticket()
    {
        return $this->belongsTo('Task\Model\Ticket');
    }
} 