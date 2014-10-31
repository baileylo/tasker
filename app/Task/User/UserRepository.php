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

    /**
     * @param int   $id
     * @param array $relationships
     *
     * @return User|null
     */
    public function findById($id, array $relationships = []);
} 