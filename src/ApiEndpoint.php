<?php
namespace CivilServices\Api;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use ReflectionClass;
use Session;

/**
 * An abstract Civil Services API endpoint, which assumes a URL pattern that matches
 * the concrete class name and handles requests.
 */
abstract class ApiEndpoint {

    // The Guzzle client that handles requests.
    private $client;

    // The URL of the endpoint, defaults to the classname, lower-cased.
    protected $endpoint;

    /**
     * Construct a new API endpoint using the given HTTP client.
     * @param $client
     */
    public function __construct($client) {
        $this->client = $client;

        if (!$this->endpoint) {
            $this->endpoint = strtolower((new ReflectionClass($this))->getShortName());
        }
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
     * Returns the root URL of the endpoint.
     */
    protected function getUrl() {
        return '/' . $this->endpoint;
    }

}
