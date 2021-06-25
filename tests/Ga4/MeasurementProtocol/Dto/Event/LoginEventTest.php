<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 25.06.2021
 * Time: 13:40
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Event;

use Br33f\Ga4\MeasurementProtocol\Dto\Event\LoginEvent;
use Tests\Common\BaseTestCase;

class LoginEventTest extends BaseTestCase
{
    /**
     * @var LoginEvent
     */
    protected $event;

    public function testDefaultConstructor()
    {
        $constructedEvent = new LoginEvent();

        $this->assertNotNull($constructedEvent);
        $this->assertEquals('login', $constructedEvent->getName());
    }

    public function testValidateSuccess()
    {
        $this->event->setMethod($this->faker->word);

        $this->assertTrue($this->event->validate());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->event = new LoginEvent();
    }
}
