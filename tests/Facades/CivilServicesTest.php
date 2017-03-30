<?php

namespace CivilServices\Api\Test;

use PHPUnit_Framework_TestCase;
use CivilServices\Api\Facades\CivilServices;
use CivilServices\Api\TestCase;

class CivilServicesTest extends TestCase
{
    /**
     * Check the facade can be called
     *
     * @test
     */
    public function check_the_facade_could_be_called()
    {
        CivilServices::getCacheKey('state', ['abc' => 123]);
    }
}
