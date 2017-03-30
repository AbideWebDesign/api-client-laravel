<?php

namespace CivilServices\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class ClientTest extends TestCase
{
    /**
     * @test
     */
    public function get_state_returns_data() {

        $body = file_get_contents(__DIR__ . '/mocks/get_state.json');

        $mock = new MockHandler([
            new Response(200, [], $body),
        ]);

        $handler = HandlerStack::create($mock);

        $client = new Client(['handler' => $handler]);

        $apiRequest = $client->getState('NY');

        $response = $apiRequest->getBody()->getContents();
        $api_data = json_decode($response, true);

        $this->assertTrue(is_array($api_data));
        $this->assertSame('New York', $api_data['data']['state_name']);
    }
}
