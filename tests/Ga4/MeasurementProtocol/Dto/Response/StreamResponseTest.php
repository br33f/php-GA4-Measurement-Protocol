<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 24.06.2021
 * Time: 14:25
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Response;

use Br33f\Ga4\MeasurementProtocol\Dto\Response\StreamResponse;
use GuzzleHttp\Psr7\Response;
use Tests\Common\BaseTestCase;

class StreamResponseTest extends BaseTestCase
{
    /**
     * @var StreamResponse
     */
    protected $baseResponse;

    public function testDefaultConstructor()
    {
        $constructedStreamResponse = new StreamResponse();

        $this->assertNotNull($constructedStreamResponse);
    }

    public function testBlueprintConstructor()
    {
        $response = new Response(200, [], '{"test_field": {"value": "123"}}');
        $constructedStreamResponse = new StreamResponse($response);

        $this->assertNotNull($constructedStreamResponse);
        $this->assertEquals(200, $constructedStreamResponse->getStatusCode());
        $this->assertEquals('{"test_field": {"value": "123"}}', $constructedStreamResponse->getBody());
    }

    public function testStatusCode()
    {
        $setStatusCode = 204;
        $this->streamResponse->setStatusCode($setStatusCode);

        $this->assertEquals(204, $this->streamResponse->getStatusCode());
    }

    public function testData()
    {
        $response = new Response(200, [], '{"test_field": {"value": "123"}}');
        $this->streamResponse->setBody($response->getBody());

        $this->assertEquals($response->getBody(), $this->streamResponse->getBody());
        $this->assertEquals(json_decode($response->getBody(), true), $this->streamResponse->getData());
    }

    public function testBody()
    {
        $response = new Response(200, [], '{"test_field": {"value": "123"}}');
        $this->streamResponse->setBody($response->getBody());

        $this->assertEquals($response->getBody(), $this->streamResponse->getBody());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->streamResponse = new StreamResponse();
    }
}
