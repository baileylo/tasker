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
        foreach(['Project', 'Ticket', 'User', 'Application', 'UserStream'] as $objectName) {
            $this->app->bind(
                "Portico\\Task\\{$objectName}\\{$objectName}Repository",
                "Portico\\Task\\{$objectName}\\Repository\\Eloquent"
            );
        }
    }

} 