<?php namespace Task\Model\User;

use Task\Model\User;

class EloquentRepository implements RepositoryInterface
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