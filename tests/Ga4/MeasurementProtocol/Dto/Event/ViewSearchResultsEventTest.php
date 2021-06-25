<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 25.06.2021
 * Time: 13:40
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Event;

use Br33f\Ga4\MeasurementProtocol\Dto\Event\ViewSearchResultsEvent;
use Tests\Common\BaseTestCase;

class ViewSearchResultsEventTest extends BaseTestCase
{
    /**
     * @var ViewSearchResultsEvent
     */
    protected $event;

    public function testDefaultConstructor()
    {
        $constructedEvent = new ViewSearchResultsEvent();

        $this->assertNotNull($constructedEvent);
        $this->assertEquals('view_search_results', $constructedEvent->getName());
    }

    public function testValidateSuccess()
    {
        $this->event->setSearchTerm($this->faker->paragraph);

        $this->assertTrue($this->event->validate());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->event = new ViewSearchResultsEvent();
    }
}
