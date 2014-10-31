<?php namespace Portico\Task\Ticket\Command;

use Portico\Task\Comment\Comment;
use Portico\Task\Ticket\Ticket;
use Portico\Task\User\User;

class EditTicketCommand
{
    /** @var String */
    private $name;

    /** @var Int */
    private $status;

    /** @var String */
    private $assignee_id;

    /** @var String */
    private $due_date;

    /** @var String */
    private $description;

    /** @var String */
    private $comment;

    /** @var Ticket */
    private $ticket;

    /** @var User */
    private $assignee;

    /** @var User */
    private $editor;

    /** @var  Int */
    private $type;

    function __construct(
        Ticket $ticket,
        $assignee_id,
        $comment,
        $description,
        $due_date,
        $name,
        $status,
        $type,
        User $editor
    ) {
        $this->ticket = $ticket;
        $this->assignee_id = intval($assignee_id);
        $this->comment = $comment;
        $this->description = $description;
        $this->due_date = $due_date ? new \DateTime($due_date) : null;
        $this->name = $name;
        $this->status = intval($status);
        $this->editor = $editor;
        $this->type = $type;
    }

    public function validationArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'assignee_id' => $this->assignee_id,
            'status' => $this->status,
            'type' => $this->type,
            'due_date' => $this->due_date,
            'comment' => $this->comment
        ];
    }

    /**
     * @param User $assignee
     */
    public function setAssignee(User $assignee)
    {
        $this->assignee = $assignee;
    }

    /**
     * @return User
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     * @return string
     */
    public function getAssigneeId()
    {
        return $this->assignee_id;
    }

    /**
     * @return Comment|bool
     */
    public function getComment()
    {
        if (!$this->comment) {
            return false;
        }

        $comment = new Comment();
        $comment->message = $this->comment;

        return $comment;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return \DateTime|Null
     */
    public function getDueDate()
    {
        return $this->due_date;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * @return User
     */
    public function getEditor()
    {
        return $this->editor;
    }

    /**
     * @return Int
     */
    public function getType()
    {
        return $this->type;
    }
} 