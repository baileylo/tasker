<?php namespace Portico\Task\User;

interface UserRepository
{
    /**
     * @param string    $email
     * @param string[]  $relationships
     *
     * @return User|Null
     */
    public function findByEmail($email, array $relationships = []);
} 