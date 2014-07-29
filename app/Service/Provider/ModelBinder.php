<?php namespace Task\Service\Provider;

use Illuminate\Support\ServiceProvider;

class ModelBinder extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        foreach(['Project', 'Ticket', 'User', 'Application'] as $objectName) {
            $this->app->bind(
                'Task\Model\\' . $objectName . '\RepositoryInterface',
                'Task\Model\\' . $objectName . '\EloquentRepository'
            );
        }

    }

} 