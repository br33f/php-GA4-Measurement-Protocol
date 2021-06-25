<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 25.06.2021
 * Time: 13:40
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Event;

use Br33f\Ga4\MeasurementProtocol\Dto\Event\SearchEvent;
use Br33f\Ga4\MeasurementProtocol\Exception\ValidationException;
use Tests\Common\BaseTestCase;

class SearchEventTest extends BaseTestCase
{
    /**
     * @var SearchEvent
     */
    protected $event;

    public function testDefaultConstructor()
    {
        $constructedEvent = new SearchEvent();

        $this->assertNotNull($constructedEvent);
        $this->assertEquals('search', $constructedEvent->getName());
    }

    public function testValidateSuccess()
    {
        $this->event->setSearchTerm($this->faker->paragraph);

        $this->assertTrue($this->event->validate());
    }

    public function testValidateFail()
    {
        $this->event = new SearchEvent();

        $this->expectException(ValidationException::class);
        $this->event->validate();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->event = new SearchEvent();
    }
}
