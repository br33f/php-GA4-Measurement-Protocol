<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 23.06.2021
 * Time: 14:42
 */

namespace Tests\Ga4\MeasurementProtocol;

use Br33f\Ga4\MeasurementProtocol\Dto\Event\BaseEvent;
use Br33f\Ga4\MeasurementProtocol\Dto\Request\BaseRequest;
use Br33f\Ga4\MeasurementProtocol\Dto\Response\AbstractResponse;
use Br33f\Ga4\MeasurementProtocol\Dto\Response\DebugResponse;
use Br33f\Ga4\MeasurementProtocol\Exception\MisconfigurationException;
use Br33f\Ga4\MeasurementProtocol\HttpClient;
use Br33f\Ga4\MeasurementProtocol\Service;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\Common\BaseTestCase;

class ServiceTest extends BaseTestCase
{
    /**
     * @var Service
     */
    protected $service;

    public function testConstructor()
    {
        $setApiSecret = $this->faker->word;
        $setMeasurementId = $this->faker->bothify('**-########');
        $constructedService = new Service($setApiSecret, $setMeasurementId);

        $this->assertEquals($setApiSecret, $constructedService->getApiSecret());
        $this->assertEquals($setMeasurementId, $constructedService->getMeasurementId());
    }

    public function testUseSsl()
    {
        $this->service->setUseSsl(true);
        $this->assertTrue($this->service->isUseSsl());

        $this->service->setUseSsl(false);
        $this->assertFalse($this->service->isUseSsl());
    }

    public function testUsewww()
    {
        $this->service->setUseWww(true);
        $this->assertTrue($this->service->isUseWww());

        $this->service->setUseWww(false);
        $this->assertFalse($this->service->isUseWww());
    }

    public function testCollectEndpoint()
    {
        $setCollectEndpoint = str_replace('https://', '', $this->faker->url);
        $setCollectEndpoint = str_replace('http://', '', $setCollectEndpoint);

        $this->service->setCollectEndpoint($setCollectEndpoint);

        $this->assertEquals($setCollectEndpoint, $this->service->getCollectEndpoint());
    }

    public function testCollectDebugEndpoint()
    {
        $setCollectDebugEndpoint = str_replace('https://', '', $this->faker->url);
        $setCollectDebugEndpoint = str_replace('http://', '', $setCollectDebugEndpoint);

        $this->service->setCollectDebugEndpoint($setCollectDebugEndpoint);

        $this->assertEquals($setCollectDebugEndpoint, $this->service->getCollectDebugEndpoint());
    }

    public function testMeasurementId()
    {
        $setMeasurementId = $this->faker->bothify('**-########');
        $this->service->setMeasurementId($setMeasurementId);

        $this->assertEquals($setMeasurementId, $this->service->getMeasurementId());
    }

    public function testSetApiSecret()
    {
        $setApiSecret = $this->faker->word;
        $this->service->setApiSecret($setApiSecret);

        $this->assertEquals($setApiSecret, $this->service->getApiSecret());
    }

    public function testHttpClient()
    {
        $setHttpClient = new HttpClient();
        $this->service->setHttpClient($setHttpClient);

        $this->assertEquals($setHttpClient, $this->service->getHttpClient());
    }

    public function testHttpClientWhenEmpty()
    {
        $setApiSecret = $this->faker->word;
        $setMeasurementId = $this->faker->bothify('**-########');
        $constructedService = new Service($setApiSecret, $setMeasurementId);

        $this->assertNotNull($constructedService->getHttpClient());
    }

    public function testEndpoint()
    {
        $setApiSecret = $this->faker->word;
        $setMeasurementId = $this->faker->bothify('**-########');

        $newService = new Service($setApiSecret, $setMeasurementId);

        $setCollectEndpoint = str_replace('https://', '', $this->faker->url);
        $setCollectEndpoint = str_replace('http://', '', $setCollectEndpoint);
        $newService->setCollectEndpoint($setCollectEndpoint);
        $newService->setUseSsl(true);

        $getParams = '?' . http_build_query(['api_secret' => $newService->getApiSecret(), 'measurement_id' => $newService->getMeasurementId()]);
        $this->assertEquals(Service::SSL_SCHEME . $setCollectEndpoint . $getParams, $newService->getEndpoint());

        $newService->setUseSsl(false);
        $this->assertEquals(Service::NOT_SSL_SCHEME . $setCollectEndpoint . $getParams, $newService->getEndpoint());

        $setCollectDebugEndpoint = str_replace('https://', '', $this->faker->url);
        $setCollectDebugEndpoint = str_replace('http://', '', $setCollectDebugEndpoint);
        $newService->setCollectDebugEndpoint($setCollectDebugEndpoint);
        $newService->setUseSsl(true);
        $this->assertEquals(Service::SSL_SCHEME . $setCollectDebugEndpoint . $getParams, $newService->getEndpoint(true));

        $newService->setUseSsl(false);
        $this->assertEquals(Service::NOT_SSL_SCHEME . $setCollectDebugEndpoint . $getParams, $newService->getEndpoint(true));
    }

    public function testOptions()
    {
        $setOptions = [
            'timeout' => '25',
            'headers' => [
                'User-Agent' => 'Test User Agent'
            ]
        ];
        $this->service->setOptions($setOptions);

        $this->assertEquals($setOptions, $this->service->getOptions());
    }

    public function testSend()
    {
        $mock = new MockHandler([
            new Response(200)
        ]);

        $handlerStack = HandlerStack::create($mock);
        $mockClient = new Client(['handler' => $handlerStack]);

        $setApiSecret = $this->faker->word;
        $setMeasurementId = $this->faker->bothify('**-########');
        $sendService = new Service($setApiSecret, $setMeasurementId);
        $sendService->getHttpClient()->setClient($mockClient);

        $setClientId = $this->faker->asciify('********************.********************');
        $sentRequest = new BaseRequest($setClientId);
        $event = new BaseEvent($this->faker->word);
        $sentRequest->addEvent($event);

        $baseResponse = $sendService->send($sentRequest);
        $this->assertTrue($baseResponse instanceof AbstractResponse);
        $this->assertEquals(200, $baseResponse->getStatusCode());
    }

    public function testSendWithIpOverride()
    {
        $mock = new MockHandler([
            new Response(200)
        ]);

        $handlerStack = HandlerStack::create($mock);
        $mockClient = new Client(['handler' => $handlerStack]);

        $setApiSecret = $this->faker->word;
        $setMeasurementId = $this->faker->bothify('**-########');
        $sendService = new Service($setApiSecret, $setMeasurementId);
        $sendService->getHttpClient()->setClient($mockClient);

        $sendService->setIpOverride($this->faker->ipv4);

        $setClientId = $this->faker->asciify('********************.********************');
        $sentRequest = new BaseRequest($setClientId);
        $event = new BaseEvent($this->faker->word);
        $sentRequest->addEvent($event);

        $baseResponse = $sendService->send($sentRequest);
        $this->assertTrue($baseResponse instanceof AbstractResponse);
        $this->assertEquals(200, $baseResponse->getStatusCode());
    }


    public function testSendDebugWithError()
    {
        $mock = new MockHandler([
            new Response(200, [], '{
                "validationMessages": [
                    {
                        "description": "Unable to parse Measurement Protocol JSON payload. (events[0]) names: Cannot find field.",
                        "validationCode": "VALUE_INVALID"
                    }
                ]
            }')
        ]);

        $handlerStack = HandlerStack::create($mock);
        $mockClient = new Client(['handler' => $handlerStack]);

        $setApiSecret = $this->faker->word;
        $setMeasurementId = $this->faker->bothify('**-########');
        $sendService = new Service($setApiSecret, $setMeasurementId);
        $sendService->getHttpClient()->setClient($mockClient);

        $setClientId = $this->faker->asciify('********************.********************');
        $sentRequest = new BaseRequest($setClientId);
        $event = new BaseEvent($this->faker->word);
        $sentRequest->addEvent($event);

        $debugResponse = $sendService->sendDebug($sentRequest);
        $this->assertTrue($debugResponse instanceof DebugResponse);
        $this->assertEquals(200, $debugResponse->getStatusCode());
        $this->assertEquals(1, count($debugResponse->getValidationMessages()));
    }

    public function testMisconfigBothInGetQueryParameters()
    {
        $setApiSecret = $this->faker->word;
        $setMeasurementId = $this->faker->bothify('**-########');
        $setFirebaseId = $this->faker->bothify('**-########');
        $testService = new Service($setApiSecret, $setMeasurementId);
        $testService->setFirebaseId($setFirebaseId);

        $this->expectException(MisconfigurationException::class);
        $testService->getQueryParameters();
    }

    public function testMisconfigApiSecretEmptyInGetQueryParameters()
    {
        $setApiSecret = $this->faker->word;
        $setMeasurementId = $this->faker->bothify('**-########');
        $setFirebaseId = $this->faker->bothify('**-########');
        $testService = new Service($setApiSecret, $setMeasurementId);
        $testService->setFirebaseId($setFirebaseId);

        $this->expectException(MisconfigurationException::class);
        $testService->getQueryParameters();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new Service($this->faker->word, $this->faker->bothify('**-########'));
    }
}
