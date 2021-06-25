<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 24.06.2021
 * Time: 14:25
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Response;

use Br33f\Ga4\MeasurementProtocol\Dto\Common\ValidationMessage;
use Br33f\Ga4\MeasurementProtocol\Dto\Response\DebugResponse;
use GuzzleHttp\Psr7\Response;
use Tests\Common\BaseTestCase;

class DebugResponseTest extends BaseTestCase
{
    /**
     * @var DebugResponse
     */
    protected $debugResponse;

    public function testDefaultConstructor()
    {
        $constructedDebugResponse = new DebugResponse();

        $this->assertNotNull($constructedDebugResponse);
    }

    public function testBlueprintConstructor()
    {
        $response = new Response(200, [], '{
            "validationMessages": [
                {
                    "description": "Unable to parse Measurement Protocol JSON payload. (events[0]) names: Cannot find field.",
                    "validationCode": "VALUE_INVALID"
                }
            ]
        }');

        $parsedValidationMessage = new ValidationMessage(json_decode('{
                    "description": "Unable to parse Measurement Protocol JSON payload. (events[0]) names: Cannot find field.",
                    "validationCode": "VALUE_INVALID"
                }', true));

        $constructedDebugResponse = new DebugResponse($response);

        $this->assertNotNull($constructedDebugResponse);
        $this->assertEquals(200, $constructedDebugResponse->getStatusCode());
        $this->assertEquals(1, count($constructedDebugResponse->getValidationMessages()));
        $this->assertEquals($parsedValidationMessage, $constructedDebugResponse->getValidationMessages()[0]);
    }

    public function testBody()
    {
        $setValidationMessages = [new ValidationMessage(['fieldPath' => 'test123'])];
        $this->debugResponse->setValidationMessages($setValidationMessages);

        $this->assertEquals($setValidationMessages, $this->debugResponse->getValidationMessages());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->debugResponse = new DebugResponse();
    }
}
