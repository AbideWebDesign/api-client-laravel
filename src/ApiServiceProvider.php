<?php
namespace CivilServices\Api;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;

/**
 * A Laravel service provider that injects all of the Civil Service API endpoints
 * into the service container.
 */
class ApiServiceProvider extends ServiceProvider {

    /**
     * Publish configuration.
     */
    public function boot() {
        $source = realpath(__DIR__ . '/../config/civilservices.php');

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('civilservices.php')]);
        }

        $this->mergeConfigFrom($source, 'civilservices');
    }

    /**
     * Register all of the endpoints in the service container.
     */
    public function register() {
        $config = $this->app['config']->get('civilservices');

        // all endpoints use the same HTTP client.
        $api_client = new GuzzleHttpClient([
            'base_url' => [
                $config['api_base'] . '/{version}/',
                [
                    'version' => $config['api_version']
                ]
            ],
            'defaults' => [
                'headers' => [
                    'API-Key' => $config['api_key']
                ]
            ]

        ]);

        foreach (self::$endpoints as $endpoint) {
            $this->app->singleton($endpoint, function() use($api_client, $endpoint) {
                return new $endpoint($api_client);
            });
        }
    }

    /**
     * A list of all the endpoint classes.
     */
    private static $endpoints = [
        Endpoints\Categories::class,
    ];
}