<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 23.06.2021
 * Time: 12:23
 */

namespace Tests\Ga4\MeasurementProtocol;

use Br33f\Ga4\MeasurementProtocol\HttpClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\Common\BaseTestCase;

class HttpClientTest extends BaseTestCase
{
    /**
     * @var HttpClient
     */
    protected $httpClient;

    public function testDefaultConstructor()
    {
        $constructedHttpClient = new HttpClient();

        $this->assertNotNull($constructedHttpClient);
    }

    public function testClient()
    {
        $setClient = new Client();
        $this->httpClient->setClient($setClient);

        $this->assertEquals($setClient, $this->httpClient->getClient());
    }

    public function testGetClientWhenNotSet()
    {
        $emptyHttpClient = new HttpClient();

        $this->assertNotNull($emptyHttpClient->getClient());
    }

    public function testPost()
    {
        $mock = new MockHandler([
            new Response(204),
            new Response(403),
            new Response(500)
        ]);

        $handlerStack = HandlerStack::create($mock);
        $mockClient = new Client(['handler' => $handlerStack]);

        $newHttpClient = new HttpClient();
        $newHttpClient->setClient($mockClient);

        $response = $newHttpClient->post($this->faker->url, []);
        $this->assertEquals(204, $response->getStatusCode());

        $response = $newHttpClient->post($this->faker->url, []);
        $this->assertEquals(403, $response->getStatusCode());

        $response = $newHttpClient->post($this->faker->url, []);
        $this->assertEquals(500, $response->getStatusCode());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->httpClient = new HttpClient();
    }
}
