<?php namespace Task\Model;

use Eloquent;

/**
 * Task\Model\Ticket
 *
 * @property-read \Task\Model\User $reporter
 * @property-read \Task\Model\Project $project
 * @property-read \Illuminate\Database\Eloquent\Collection|\Task\Model\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\Task\Model\User[] $subscribers
 */
class Ticket extends Eloquent
{
    protected $table = 'tickets';

    public function reporter()
    {
        return $this->belongsTo('Task\Model\User', 'reporter_id');
    }

    public function project()
    {
        return $this->belongsTo('Task\Model\Project');
    }

    public function comments()
    {
        return $this->hasMany('Task\Model\Comment');
    }

    public function subscribers()
    {
        return $this->belongsToMany('Task\Model\User');
    }

    public function getDates()
    {
        return ['created_at', 'updated_at', 'due_at'];
    }


} 