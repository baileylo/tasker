<?php namespace Task\Model\Application;

use Task\Model\Application;

interface RepositoryInterface
{
    /**
     * @return Application
     */
    public function findSettings();

    /**
     * Determine if the storage engine for Application information is primed.
     *
     * @return bool
     */
    public function tableExists();
} 