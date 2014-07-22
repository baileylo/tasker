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
        $this->app->bind(
            'Task\Model\Project\RepositoryInterface',
            'Task\Model\Project\EloquentRepository'
        );
    }

} 