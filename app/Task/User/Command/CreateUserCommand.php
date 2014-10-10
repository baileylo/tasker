<?php namespace Portico\Task\User\Command;

class CreateUserCommand
{
    /** @var String User's first name */
    protected $firstName;

    /** @var String User's last name */
    protected $lastName;

    /** @var String User's email address */
    protected $email;

    public function __construct($email, $firstName, $lastName)
    {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }


} 