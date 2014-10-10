<?php namespace Portico\Task\User\Events;

use Portico\Task\User\User;

class UserWasCreated
{
    /** @var User */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
} 