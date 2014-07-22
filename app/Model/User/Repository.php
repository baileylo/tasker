<?php namespace Task\Model\User;


use Task\Model\User;

class Repository {

    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function findByEmail($email, array $relationships = [])
    {

    }
} 