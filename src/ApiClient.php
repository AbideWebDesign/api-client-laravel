<?php

namespace CivilServices\Api;

use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Support\Facades\Cache;

class Client
{
    /**
     * @var GuzzleHttp API Client
     */
    protected $client;

   
    /**
     * Create new instance of Pixelpeter\Genderize\GenderizeClient
     */
    public function __construct(Request $request)
    {
        $config = $this->app['config']->get('civilservices');

        // all endpoints use the same HTTP client.
        $this->client = new GuzzleHttpClient([
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
    }

    /**
     * Make a request to the endpoint.
     *
     * @param $method
     * @param $url
     * @param array $payload
     * @return mixed
     */
    protected function makeRequest($method, $url, $payload=[]) {
        $cache_url = $url . '?' . http_build_query($payload);
        $cache_key = 'api:query:' . md5($cache_url);
        $cached_response = Cache::get($cache_key);

        if ($cached_response) {
            return json_decode($cached_response);
        } else {
            $apiRequest = $this->client->request($method, $url, $payload);
            $response = $apiRequest->getBody()->getContents();
            $api_data = json_decode($response);

            if ($api_data->error) {
                // @TODO: Handler Error
            } else {
                Cache::add($cache_key, $response, 3600);
                return $api_data;
            }
        }
    }
    
    /**
     * Send the request
     *
     * @return GenderizeResponse
     */
    public function getCategories($query)
    {
        $response = $this->makeRequest('GET', 'categories', ['query' => $query]);

        return $response;
    }
}