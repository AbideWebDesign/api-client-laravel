<?php

namespace CivilServices\Api;

use Illuminate\Support\ServiceProvider;

class CivilServicesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('civilservices', function() {
            return new Api;
        });
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/config/civilservices.php', 'civilservices'
        );
    }
    public function boot()
    {
        $this->publishes([
            dirname(__DIR__) . '/config' => config_path('civilservices')
        ], 'config');
    }
}