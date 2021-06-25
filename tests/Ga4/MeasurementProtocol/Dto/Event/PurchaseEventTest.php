<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 25.06.2021
 * Time: 13:40
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Event;

use Br33f\Ga4\MeasurementProtocol\Dto\Event\PurchaseEvent;
use Br33f\Ga4\MeasurementProtocol\Exception\ValidationException;
use Tests\Common\BaseTestCase;

class PurchaseEventTest extends BaseTestCase
{
    /**
     * @var PurchaseEvent
     */
    protected $event;

    public function testDefaultConstructor()
    {
        $constructedEvent = new PurchaseEvent();

        $this->assertNotNull($constructedEvent);
        $this->assertEquals('purchase', $constructedEvent->getName());
    }

    public function testValidateSuccess()
    {
        $this->event->setValue($this->faker->randomFloat(2, 10, 3000));
        $this->event->setCurrency($this->faker->currencyCode);
        $this->event->setTransactionId($this->faker->bothify('*#*#*#_transaction'));

        $this->assertTrue($this->event->validate());
    }

    public function testValidateFailNoCurrency()
    {
        $this->event->setValue($this->faker->randomFloat(2, 10, 3000));
        $this->event->setTransactionId($this->faker->bothify('*#*#*#_transaction'));

        $this->expectException(ValidationException::class);
        $this->event->validate();
    }

    public function testValidateFailNoTransaction()
    {
        $this->event->setValue($this->faker->randomFloat(2, 10, 3000));
        $this->event->setCurrency($this->faker->currencyCode);

        $this->expectException(ValidationException::class);
        $this->event->validate();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->event = new PurchaseEvent();
    }
}
