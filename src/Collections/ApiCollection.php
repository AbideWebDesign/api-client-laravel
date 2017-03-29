<?php
namespace CivilServices\Api\Collections;

use Illuminate\Support\Collection;

/**
 * A collection of resources, along with meta data describing how filters have
 * been applied to the collection.
 */
class ApiCollection extends Collection {

    // The metadata for collection.
    private $meta;

    /**
     * Returns the metadata for the collection.
     */
    public function getMeta() {
        return $this->meta;
    }

    /**
     * Construct a new collection from the given API response.
     * @param $response
     * @return static
     */
    public static function fromResponse($response) {
        $collection = new static(array_get($response, 'data', []));
        $collection->meta = array_get($response, 'meta', []);
        return $collection;
    }

}
