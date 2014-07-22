<?php namespace Task\Model;

use Eloquent;

/**
 * Task\Model\Comment
 *
 * @property-read \Task\Model\User $author
 * @property-read \Task\Model\Ticket $ticket
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