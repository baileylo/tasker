<?php namespace Task\Service\Provider;

use Illuminate\Support\ServiceProvider;

class RouteBinder extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        /** @var \Task\Model\Project\RepositoryInterface $projectRepo */
        $projectRepo = $this->app->make('Task\Model\Project\RepositoryInterface');

        $this->app->make('Illuminate\Routing\Router')->bind('projectId', function($projectId) use ($projectRepo) {
            return $projectRepo->findById($projectId);
        });

    }

}