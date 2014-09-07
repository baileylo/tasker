<?php namespace Portico\Task\Project\Repository;

use Portico\Task\Project\Project;
use Portico\Task\Project\ProjectRepository;

class Eloquent implements ProjectRepository
{
    /**
     * @var \Portico\Task\Project\Project
     */
    protected $orm;

    public function __construct(Project $project)
    {
        $this->orm = $project;
    }

    /**
     * @param array $relationships
     *
     * @return Project[]
     */
    public function findAll(array $relationships = [])
    {
        return $this->orm->with($relationships)->get();
    }

    /**
     * @param int $projectId
     * @param string[] $relationships
     *
     * @return Project|Null
     */
    public function findById($projectId, array $relationships = [])
    {
        return $this->orm->with($relationships)->find(intval($projectId));
    }
}