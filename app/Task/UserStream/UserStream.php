<?php namespace Portico\Task\UserStream;

use Eloquent;

/**
 * Task\UserStream
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $object_id
 * @property integer $type
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\UserStream\UserStream whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\UserStream\UserStream whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\UserStream\UserStream whereObjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\Portico\Task\UserStream\UserStream whereType($value)
 */
class UserStream extends Eloquent
{
    const TYPE_TICKET_CREATED = 1;
    const TYPE_TICKET_CLOSED = 2;
    const TYPE_TICKET_UPDATED = 3;

    protected $table = 'user_streams';

    public function ticket()
    {
        return $this->belongsTo('Portico\Task\Ticket\Ticket', 'object_id');
    }
} 