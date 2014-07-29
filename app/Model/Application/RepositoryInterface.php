<?php namespace Task\Model\Application;

use Task\Model\Application;

interface RepositoryInterface
{
    /**
     * @return Application
     */
    public function findSettings();
} 