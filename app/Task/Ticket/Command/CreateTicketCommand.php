<?php namespace Portico\Task\Ticket\Command;

use Portico\Task\Project\Project;
use Portico\Task\User\User;

class CreateTicketCommand
{
    protected $description;

    protected $name;

    protected $type;

    protected $dueDate;

    protected $assigneeEmailAddress;

    protected $assignee;

    /**
     * @var Project
     */
    private $project;
    /**
     * @var User
     */
    private $creator;

    function __construct($name, $description, $type, User $creator, Project $project, $assignee = null, $dueDate = null)
    {
        $this->assigneeEmailAddress = $assignee;
        $this->description = $description;
        $this->dueDate = $dueDate;
        $this->name = $name;
        $this->type = $type;
        $this->project = $project;
        $this->creator = $creator;
    }

    /**
     * @return mixed
     */
    public function getAssigneeEmailAddress()
    {
        return $this->assigneeEmailAddress;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return User
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    public function setAssignee(User $assignee)
    {
        $this->assignee = $assignee;
    }

    public function getAssignee()
    {
        return $this->assignee;
    }

    public function toArray()
    {
        return [
            'assignee' => $this->getAssignee(),
            'project' => $this->getProject(),
            'creator' => $this->getCreator(),
            'type' => $this->getType(),
            'name' => $this->getName(),
            'dueDate' => $this->getDueDate(),
            'description' => $this->getDescription(),
            'assigneeEmailAddress' => $this->getAssigneeEmailAddress()
        ];
    }
} 