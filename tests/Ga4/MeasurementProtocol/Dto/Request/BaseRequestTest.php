<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 22.06.2021
 * Time: 16:06
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Request;

use Br33f\Ga4\MeasurementProtocol\Dto\Common\EventCollection;
use Br33f\Ga4\MeasurementProtocol\Dto\Common\UserProperties;
use Br33f\Ga4\MeasurementProtocol\Dto\Common\UserProperty;
use Br33f\Ga4\MeasurementProtocol\Dto\Event\BaseEvent;
use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\BaseParameter;
use Br33f\Ga4\MeasurementProtocol\Dto\Request\BaseRequest;
use Br33f\Ga4\MeasurementProtocol\Enum\ErrorCode;
use Tests\Common\BaseTestCase;

class BaseRequestTest extends BaseTestCase
{
    /**
     * @var BaseRequest
     */
    protected $baseRequest;

    public function testDefaultConstructor()
    {
        $constructedBaseRequest = new BaseRequest();

        $this->assertNotNull($constructedBaseRequest);
    }

    public function testAbstractEventConstructor()
    {
        $event = new BaseEvent();
        $constructedBaseRequest = new BaseRequest(null, $event);

        $this->assertNotNull($constructedBaseRequest);
        $this->assertCount(1, $constructedBaseRequest->getEvents()->getEventList());
        $this->assertEquals($event, $constructedBaseRequest->getEvents()->getEventList()[0]);
    }

    public function testClientId()
    {
        $setClientId = $this->faker->asciify('********************.********************');
        $this->baseRequest->setClientId($setClientId);

        $this->assertEquals($setClientId, $this->baseRequest->getClientId());
    }

    public function testUserId()
    {
        $setUserId = $this->faker->asciify('*********');
        $this->baseRequest->setUserId($setUserId);

        $this->assertEquals($setUserId, $this->baseRequest->getUserId());
    }

    public function testTimestampMicros()
    {
        $setTimestampMicros = $this->faker->unixTime * 1000;
        $this->baseRequest->setTimestampMicros($setTimestampMicros);

        $this->assertEquals($setTimestampMicros, $this->baseRequest->getTimestampMicros());
    }

    public function testNonPersonalizedAds()
    {
        $this->baseRequest->setNonPersonalizedAds(true);
        $this->assertEquals(true, $this->baseRequest->isNonPersonalizedAds());

        $this->baseRequest->setNonPersonalizedAds(false);
        $this->assertEquals(false, $this->baseRequest->isNonPersonalizedAds());
    }

    public function testUserProperties()
    {
        $setUserProperties = new UserProperties();
        $this->baseRequest->setUserProperties($setUserProperties);

        $this->assertEquals($setUserProperties, $this->baseRequest->getUserProperties());
    }

    public function testAddUserProperty()
    {
        $addUserProperty = new UserProperty($this->faker->word, $this->faker->word);
        $this->baseRequest->addUserProperty($addUserProperty);

        $this->assertEquals(1, count($this->baseRequest->getUserProperties()->getUserPropertiesList()));
        $this->assertEquals($addUserProperty, $this->baseRequest->getUserProperties()->getUserPropertiesList()[0]);
    }

    public function testEvents()
    {
        $setEvents = new EventCollection();
        $event = new BaseEvent($this->faker->word);
        $event->addParam($this->faker->word, new BaseParameter($this->faker->word));
        $setEvents->addEvent($event);
        $this->baseRequest->setEvents($setEvents);

        $this->assertEquals($setEvents, $this->baseRequest->getEvents());
    }

    public function testAddEvent()
    {
        $this->baseRequest->setEvents(new EventCollection());

        $event = new BaseEvent($this->faker->word);
        $event->addParam($this->faker->word, new BaseParameter($this->faker->word));

        $this->baseRequest->addEvent($event);

        $this->assertEquals(1, count($this->baseRequest->getEvents()->getEventList()));
        $this->assertEquals($event, $this->baseRequest->getEvents()->getEventList()[0]);
    }

    public function testValidateFailed()
    {
        $newBaseRequest = new BaseRequest();

        $this->expectExceptionCode(ErrorCode::VALIDATION_CLIENT_ID_REQUIRED);
        $newBaseRequest->validate();
    }

    public function testValidateSuccess()
    {
        $setClientId = $this->faker->asciify('********************.********************');
        $setEventCollection = new EventCollection();
        $event = new BaseEvent($this->faker->word);
        $event->addParam($this->faker->word, new BaseParameter($this->faker->word));
        $setEventCollection->addEvent($event);
        $newBaseRequest = new BaseRequest($setClientId, $setEventCollection);

        $this->assertTrue($newBaseRequest->validate());
    }

    public function testExportOnlyRequiredParameters()
    {
        $setClientId = $this->faker->asciify('********************.********************');
        $setEventCollection = new EventCollection();
        $event = new BaseEvent($this->faker->word);
        $event->addParam($this->faker->word, new BaseParameter($this->faker->word));
        $setEventCollection->addEvent($event);

        $exportBaseRequest = new BaseRequest($setClientId, $setEventCollection);

        $this->assertEquals([
            'client_id' => $setClientId,
            'events' => $setEventCollection->export(),
            'non_personalized_ads' => false
        ], $exportBaseRequest->export());
    }

    public function testExportAllParameters()
    {
        $setClientId = $this->faker->asciify('********************.********************');
        $setEventCollection = new EventCollection();
        $event = new BaseEvent($this->faker->word);
        $event->addParam($this->faker->word, new BaseParameter($this->faker->word));
        $setEventCollection->addEvent($event);

        $exportBaseRequest = new BaseRequest($setClientId, $setEventCollection);

        $setUserId = $this->faker->asciify('************');
        $exportBaseRequest->setUserId($setUserId);

        $setTimestampMicros = $this->faker->unixTime * 1000;
        $exportBaseRequest->setTimestampMicros($setTimestampMicros);

        $setUserProperties = new UserProperties();
        $exportBaseRequest->setUserProperties($setUserProperties);

        $this->assertEquals([
            'client_id' => $setClientId,
            'events' => $setEventCollection->export(),
            'non_personalized_ads' => false,
            'user_id' => $setUserId,
            'timestamp_micros' => $setTimestampMicros,
            'user_properties' => $setUserProperties->export()
        ], $exportBaseRequest->export());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->baseRequest = new BaseRequest();
    }
}
