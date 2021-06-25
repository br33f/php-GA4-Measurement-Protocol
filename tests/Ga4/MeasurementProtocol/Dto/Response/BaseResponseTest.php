<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 24.06.2021
 * Time: 14:25
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Response;

use Br33f\Ga4\MeasurementProtocol\Dto\Response\BaseResponse;
use GuzzleHttp\Psr7\Response;
use Tests\Common\BaseTestCase;

class BaseResponseTest extends BaseTestCase
{
    /**
     * @var BaseResponse
     */
    protected $baseResponse;

    public function testDefaultConstructor()
    {
        $constructedBaseResponse = new BaseResponse();

        $this->assertNotNull($constructedBaseResponse);
    }

    public function testBlueprintConstructor()
    {
        $response = new Response(200, [], '{"test_field": {"value": "123"}}');
        $constructedBaseResponse = new BaseResponse($response);

        $this->assertNotNull($constructedBaseResponse);
        $this->assertEquals(200, $constructedBaseResponse->getStatusCode());
        $this->assertEquals('{"test_field": {"value": "123"}}', $constructedBaseResponse->getBody());
    }

    public function testStatusCode()
    {
        $setStatusCode = 204;
        $this->baseResponse->setStatusCode($setStatusCode);

        $this->assertEquals(204, $this->baseResponse->getStatusCode());
    }

    public function testData()
    {
        $setBody = '{"test_field": {"value": "321"}}';
        $this->baseResponse->setBody($setBody);

        $this->assertEquals($setBody, $this->baseResponse->getBody());
        $this->assertEquals(json_decode($setBody, true), $this->baseResponse->getData());
    }

    public function testBody()
    {
        $setBody = '{"test_field": {"value": "321"}}';
        $this->baseResponse->setBody($setBody);

        $this->assertEquals($setBody, $this->baseResponse->getBody());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->baseResponse = new BaseResponse();
    }
}
