<?php namespace Portico\Task\ServiceProvider;

use Illuminate\Support\ServiceProvider;

class ArtisanServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            'Portico\Task\Console\Install'
        ]);
    }
}