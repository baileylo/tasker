<?php namespace Portico\Task\Project;

interface ProjectRepository
{
    /**
     * @param array $relationships
     *
     * @return Project[]
     */
    public function findAll(array $relationships = []);

    /**
     * @param int       $projectId
     * @param string[]  $relationships
     *
     * @return Project|Null
     */
    public function findById($projectId, array $relationships = []);
} 