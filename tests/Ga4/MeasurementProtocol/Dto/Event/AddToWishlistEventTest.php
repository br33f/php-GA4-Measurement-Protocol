<?php
/**
 * User: Alexis POUPELIN (AlexisPPLIN)
 * Date: 22.11.2023
 * Time: 15:00
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Event;

use Br33f\Ga4\MeasurementProtocol\Dto\Event\AddToWishlistEvent;
use Br33f\Ga4\MeasurementProtocol\Exception\ValidationException;
use Tests\Common\BaseTestCase;

class AddToWishlisEventTest extends BaseTestCase
{
    /**
     * @var AddToWishlistEvent
     */
    protected $event;

    public function testDefaultConstructor()
    {
        $constructedEvent = new AddToWishlistEvent();

        $this->assertNotNull($constructedEvent);
        $this->assertEquals('add_to_wishlist', $constructedEvent->getName());
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
        $this->event = new AddToWishlistEvent();
    }
}
