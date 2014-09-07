<?php namespace Portico\Task\ServiceProvider;

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
        /** @var \Portico\Task\Project\ProjectRepository $projectRepo */
        $projectRepo = $this->app->make('Portico\Task\Project\ProjectRepository');

        $this->app->make('Illuminate\Routing\Router')->bind('projectId', function($projectId) use ($projectRepo) {
            return $projectRepo->findById($projectId);
        });

        /** @var \Portico\Task\Ticket\TicketRepository $projectRepo */
        $ticketRepo = $this->app->make('Portico\Task\Ticket\TicketRepository');

        $this->app->make('Illuminate\Routing\Router')->bind('ticketId', function($ticketId) use ($ticketRepo) {
            return $ticketRepo->findById($ticketId);
        });

    }

}