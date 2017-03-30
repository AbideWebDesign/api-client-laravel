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
     * Create new instance of GuzzleHttp
     */
    public function __construct() {
        $this->client = new GuzzleHttpClient([
            'timeout' => 2.0,
            'base_uri' => config('civilservices.api_base') . '/' . config('civilservices.api_version') . '/'
        ]);
    }

    /**
     * Get Cache Key for URL
     * @param $endpoint
     * @param $query
     * @return string
     */
    public function getCacheKey($endpoint, $query) {
        $cache_url = $endpoint . '?' . http_build_query($query);
        return 'api:query:' . md5($cache_url);
    }

    /**
     * @param $endpoint
     * @param array $query
     * @return mixed
     */
    protected function makeRequest($endpoint, $query=[]) {
        $cache_key = $this->getCacheKey($endpoint, $query);
        $cached_response = Cache::get($cache_key);

        if ($cached_response) {
            $api_data = json_decode($cached_response);
            return $api_data->data;
        } else {
            $apiRequest = $this->client->request('GET', $endpoint, [
                'query' => $query,
                'headers' => [
                    'API-Key' => config('civilservices.api_key')
                ]
            ]);

            $response = $apiRequest->getBody()->getContents();
            $api_data = json_decode($response);

            if ($api_data->errors && count($api_data->errors) > 0) {
                // @TODO: Handler Error
            } else {
                Cache::add($cache_key, $response, 3600);
                return $api_data->data;
            }
        }
    }

    /**
     * Get City Council for Specific City & State
     *
     * EXAMPLE: Get City Council for the city and state of New York, NY
     *
     * <code>
     * use CivilServices;
     *
     * $city_council = CivilServices::getCityCouncil('NY', 'New York');
     * </code>
     *
     * @param $state
     * @param $city
     * @param array $query
     * @return mixed
     */
    public function getCityCouncil($state, $city, $query = []) {
        return $this->makeRequest("city-council/{$state}/{$city}", $query);
    }

    /**
     * Search City Council from Civil Services
     *
     * EXAMPLE: Search all City Council's in the USA for Female African American's
     *
     * <code>
     * use CivilServices;
     *
     * $city_council = CivilServices::searchCityCouncil([
     *     'gender' => 'female',
     *     'ethnicity' => 'african-american'
     * ]);
     * </code>
     *
     * @param array $query
     * @return mixed
     */
    public function searchCityCouncil($query = []) {
        return $this->makeRequest('city-council', $query);
    }


    /**
     * Get Geolocation Data for Specific Zipcode
     *
     * EXAMPLE: Get Geolocation Data for Zip Code 10004
     *
     * <code>
     * use CivilServices;
     *
     * $zipcode = CivilServices::getGeolocationZipcode('10004');
     * </code>
     *
     * @see https://api.civil.services/guide/#/reference/geolocation-endpoints/zip-code
     *
     * @param $zipcode
     * @param array $query
     * @return mixed
     */
    public function getGeolocationZipcode($zipcode, $query = []) {
        return $this->makeRequest("geolocation/zipcode/{$zipcode}", $query);
    }

    /**
     * Get Geolocation Data for Specific IP Address
     *
     * EXAMPLE: Get Geolocation Data for IP Address 97.96.74.114
     *
     * <code>
     * use CivilServices;
     *
     * $ipaddress = CivilServices::getGeolocationIP('97.96.74.114');
     * </code>
     *
     * @see https://api.civil.services/guide/#/reference/geolocation-endpoints/ip-address
     *
     * @param $ipaddress
     * @param array $query
     * @return mixed
     */
    public function getGeolocationIP($ipaddress, $query = []) {
        return $this->makeRequest("geolocation/ip/{$ipaddress}", $query);
    }

    /**
     * Search Geolocation from Civil Services
     *
     * EXAMPLE: Search all Geolocation Data in the USA with a minimum population of 1,000,000 people
     *
     * <code>
     * use CivilServices;
     *
     * $geolocation = CivilServices::searchGeolocation([
     *     'minPopulation' => 1000000
     * ]);
     * </code>
     *
     * @see https://api.civil.services/guide/#/reference/geolocation-endpoints/geolocation
     *
     * @param array $query
     * @return mixed
     */
    public function searchGeolocation($query = []) {
        return $this->makeRequest('geolocation', $query);
    }

    /**
     * Search Government from Civil Services
     *
     * EXAMPLE: Get Government Data for Specific GPS Location
     *
     * <code>
     * use CivilServices;
     *
     * $geolocation = CivilServices::searchGovernment([
     *     'latitude' => 27.782805,
     *     'longitude' => -82.63314
     * ]);
     * </code>
     *
     * @see https://api.civil.services/guide/#/reference/government-endpoints/government
     *
     * @param array $query
     * @return mixed
     */
    public function searchGovernment($query = []) {
        return $this->makeRequest('government', $query);
    }

    /**
     * Get House of Representatives from Civil Services
     *
     * EXAMPLE: Search all House of Representatives's for Female African American's
     *
     * <code>
     * use CivilServices;
     *
     * $house = CivilServices::searchHouse([
     *     'gender' => 'female',
     *     'ethnicity' => 'african-american'
     * ]);
     * </code>
     *
     * @see https://api.civil.services/guide/#/reference/house-endpoints/house
     *
     * @param array $query
     * @return mixed
     */
    public function searchHouse($query = []) {
        return $this->makeRequest('house', $query);
    }

    /**
     * Search Legislators from Civil Services ( this data currently comes from OpenStates.org )
     *
     * EXAMPLE: Get Legislators for Specific GPS Location
     *
     * <code>
     * use CivilServices;
     *
     * $legislators = CivilServices::searchLegislators([
     *     'latitude' => 27.782805,
     *     'longitude' => -82.63314
     * ]);
     * </code>
     *
     * @param array $query
     * @return mixed
     */
    public function searchLegislators($query = []) {
        return $this->makeRequest('legislators', $query);
    }

    /**
     * Search Senators from Civil Services
     *
     * EXAMPLE: Search all Senators's for Female African American's
     *
     * <code>
     * use CivilServices;
     *
     * $senate = CivilServices::searchSenate([
     *     'gender' => 'female',
     *     'ethnicity' => 'african-american'
     * ]);
     * </code>
     *
     * @see https://api.civil.services/guide/#/reference/legislator-endpoints/legislators
     *
     * @param array $query
     * @return mixed
     */
    public function searchSenate($query = []) {
        return $this->makeRequest('senate', $query);
    }

    /**
     * Get Information about a Specific State
     *
     * EXAMPLE: Get information about New York
     *
     * <code>
     * use CivilServices;
     *
     * $state = CivilServices::getState('NY');
     * </code>
     *
     * @see https://api.civil.services/guide/#/reference/state-endpoints/state
     *
     * @param array $query
     * @return mixed
     */
    public function getState($state, $query = []) {
        return $this->makeRequest("state/{$state}", $query);
    }

    /**
     * Search States from Civil Services
     *
     * EXAMPLE: Search all US States with a minimum population of 1,000,000 people
     *
     * <code>
     * use CivilServices;
     *
     * $state = CivilServices::searchStates([
     *     'minPopulation' => 1000000
     * ]);
     * </code>
     *
     * @see https://api.civil.services/guide/#/reference/state-endpoints/search
     *
     * @param array $query
     * @return mixed
     */
    public function searchStates($query = []) {
        return $this->makeRequest('state', $query);
    }
}