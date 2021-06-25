<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 22.06.2021
 * Time: 15:23
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Common;

use Br33f\Ga4\MeasurementProtocol\Dto\Common\EventCollection;
use Br33f\Ga4\MeasurementProtocol\Dto\Event\BaseEvent;
use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\BaseParameter;
use Br33f\Ga4\MeasurementProtocol\Enum\ErrorCode;
use Tests\Common\BaseTestCase;

class EventCollectionTest extends BaseTestCase
{
    /**
     * @var EventCollection
     */
    protected $eventCollection;

    public function testEventList()
    {
        $setEventList = [];
        for ($i = 0; $i < rand(1, 25); $i++) {
            $setEventList[] = new BaseEvent();
        }

        $this->eventCollection->setEventList($setEventList);

        $this->assertEquals($setEventList, $this->eventCollection->getEventList());
    }

    public function testSetEventListExceed25()
    {
        $setEventList = [];
        for ($i = 0; $i < rand(26, 50); $i++) {
            $setEventList[] = new BaseEvent();
        }

        $this->expectExceptionCode(ErrorCode::MAX_EVENT_COUNT_EXCEED);
        $this->eventCollection->setEventList($setEventList);
    }

    public function testAddEvent()
    {
        $this->eventCollection->setEventList([]);
        $newEvent = new BaseEvent();
        $this->eventCollection->addEvent($newEvent);

        $this->assertEquals(1, count($this->eventCollection->getEventList()));
        $this->assertEquals($newEvent, $this->eventCollection->getEventList()[0]);
    }

    public function testAddEventExceed25()
    {
        $setEventList = [];
        for ($i = 0; $i < 25; $i++) {
            $setEventList[] = new BaseEvent();
        }
        $this->eventCollection->setEventList($setEventList);

        $newEvent = new BaseEvent();
        $this->expectExceptionCode(ErrorCode::MAX_EVENT_COUNT_EXCEED);
        $this->eventCollection->addEvent($newEvent);
    }

    public function testExport()
    {
        $setEventListExport = [];
        $setEventList = [];
        for ($i = 0; $i < rand(1, 25); $i++) {
            $event = new BaseEvent($this->faker->word);
            $event->addParam($this->faker->word, new BaseParameter($this->faker->word));
            $setEventList[] = $event;
            $setEventListExport[] = $event->export();
        }

        $this->eventCollection->setEventList($setEventList);

        $this->assertEquals($setEventListExport, $this->eventCollection->export());
    }

    public function testValidateFailed()
    {
        $newEventCollection = new EventCollection();

        $this->expectExceptionCode(ErrorCode::VALIDATION_EVENTS_MUST_NOT_BE_EMPTY);
        $newEventCollection->validate();
    }

    public function testValidateSuccess()
    {
        $newEventCollection = new EventCollection();

        $event = new BaseEvent($this->faker->word);
        $event->addParam($this->faker->word, new BaseParameter($this->faker->word));
        $newEventCollection->addEvent($event);

        $this->assertTrue($newEventCollection->validate());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventCollection = new EventCollection();
    }
}
