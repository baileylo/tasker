<?php namespace Portico\Task\Project\Command;

class CreateProjectCommand
{
    /** @var String Name of the project */
    protected $name;

    /** @var String Description of the project */
    protected $description;

    public function __construct($name, $description)
    {
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * @return String
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }
} 