<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 25.06.2021
 * Time: 13:40
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Event;

use Br33f\Ga4\MeasurementProtocol\Dto\Event\BeginCheckoutEvent;
use Br33f\Ga4\MeasurementProtocol\Exception\ValidationException;
use Tests\Common\BaseTestCase;

class BeginCheckoutEventTest extends BaseTestCase
{
    /**
     * @var BeginCheckoutEvent
     */
    protected $event;

    public function testDefaultConstructor()
    {
        $constructedEvent = new BeginCheckoutEvent();

        $this->assertNotNull($constructedEvent);
        $this->assertEquals('begin_checkout', $constructedEvent->getName());
    }

    public function testValidateSuccess()
    {
        $this->event->setValue($this->faker->randomFloat(2, 10, 3000));
        $this->event->setCurrency($this->faker->currencyCode);

        $this->assertTrue($this->event->validate());
    }

    public function testValidateFail()
    {
        $this->event->setValue($this->faker->randomFloat(2, 10, 3000));

        $this->expectException(ValidationException::class);
        $this->event->validate();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->event = new BeginCheckoutEvent();
    }
}
