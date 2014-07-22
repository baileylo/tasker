<?php namespace Task\Model\Project;

use Task\Model\Project;

interface RepositoryInterface
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