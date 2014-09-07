<?php namespace Portico\Task\Application;

interface ApplicationRepository
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