<?php namespace Portico\Task\Application;

use Eloquent;

/**
 * Application is a key value store of random state data for the entire application, EG is it installed.
 *
 * @package Task\Model
 */
class Application extends Eloquent
{
    protected $table = 'application';

    public function isAlreadySetup()
    {
        return boolval($this->is_setup);
    }
} 