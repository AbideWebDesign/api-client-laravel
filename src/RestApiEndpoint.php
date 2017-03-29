<?php
namespace CivilServices\Api;

/**
 * An abstract Civil Services API REST endpoint, exposing the standard actions of:
 * create, retrieve, update, and delete.
 */
abstract class RestApiEndpoint extends ApiEndpoint {

    // The type to wrap collections in.
    protected $collection_type = Collections\ApiCollection::class;

    /**
     * Retrieve the entire collection, filtered according to the given query.
     * @param array $query
     * @return mixed
     */
    public function get($query = []) {
        $url = $this->getCollectionUrl();
        $response = $this->makeRequest('GET', $url, ['query' => $query]);
        return $this->collection_type::fromResponse($response);
    }
}
