<?php namespace Task\Model\User;

use Task\Model\User;

interface RepositoryInterface
{
    /**
     * @param string    $email
     * @param string[]  $relationships
     *
     * @return User|Null
     */
    public function findByEmail($email, array $relationships = []);
} 