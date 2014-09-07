<?php namespace Portico\Task\User\Repository;

use Portico\Task\User\User;
use Portico\Task\User\UserRepository;

class Eloquent implements UserRepository
{

    protected $orm;

    public function __construct(User $user)
    {
        $this->orm = $user;
    }

    /**
     * @param string $email
     * @param string[] $relationships
     *
     * @return User|Null
     */
    public function findByEmail($email, array $relationships = [])
    {
        return $this->orm->with($relationships)->whereEmail($email)->first();
    }


} 