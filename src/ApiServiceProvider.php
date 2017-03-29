<?php
namespace CivilServices\Api;

use Illuminate\Support\ServiceProvider;

/**
 * A Laravel service provider that injects all of the Civil Service API endpoints
 * into the service container.
 */
class ApiServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/civilservices.php', 'civilservices');

        $this->publishes([
            __DIR__ . '/../config/civilservices.php' => config_path('civilservices.php'),
        ]);
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        $app->bind('CivilServices\Api\Client', function () {
            return new Client();
        });

        $app->alias('CivilServices\Api\Client', 'civilservices');
    }
}