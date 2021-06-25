<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 25.06.2021
 * Time: 13:40
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Event;

use Br33f\Ga4\MeasurementProtocol\Dto\Event\SignUpEvent;
use Tests\Common\BaseTestCase;

class SignUpEventTest extends BaseTestCase
{
    /**
     * @var SignUpEvent
     */
    protected $event;

    public function testDefaultConstructor()
    {
        $constructedEvent = new SignUpEvent();

        $this->assertNotNull($constructedEvent);
        $this->assertEquals('sign_up', $constructedEvent->getName());
    }

    public function testValidateSuccess()
    {
        $this->event->setMethod($this->faker->word);

        $this->assertTrue($this->event->validate());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->event = new SignUpEvent();
    }
}
