<?php namespace Portico\Task\ServiceProvider;

use Illuminate\Support\ServiceProvider;

class EventListenerServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $event = $this->app->make('events');

        $event->listen('Portico.Task.*', 'Portico\Task\Ticket\Listeners\WatcherListener');
        $event->listen('Portico.Task.*', 'Portico\Task\Project\Listeners\WatcherListener');
        $event->listen('Portico.Task.*', 'Portico\Task\Project\Listeners\StreamBuilderListener');
    }
}