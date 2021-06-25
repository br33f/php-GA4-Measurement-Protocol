<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 25.06.2021
 * Time: 13:40
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Event;

use Br33f\Ga4\MeasurementProtocol\Dto\Event\RemoveFromCartEvent;
use Br33f\Ga4\MeasurementProtocol\Exception\ValidationException;
use Tests\Common\BaseTestCase;

class RemoveFromCartEventTest extends BaseTestCase
{
    /**
     * @var RemoveFromCartEvent
     */
    protected $event;

    public function testDefaultConstructor()
    {
        $constructedEvent = new RemoveFromCartEvent();

        $this->assertNotNull($constructedEvent);
        $this->assertEquals('remove_from_cart', $constructedEvent->getName());
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
        $this->event = new RemoveFromCartEvent();
    }
}
