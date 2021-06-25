<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 25.06.2021
 * Time: 10:44
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Event;

use Br33f\Ga4\MeasurementProtocol\Dto\Event\SelectItemEvent;
use Br33f\Ga4\MeasurementProtocol\Dto\Event\ViewItemEvent;
use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\BaseParameter;
use Tests\Common\BaseTestCase;

class SelectItemEventTest extends BaseTestCase
{
    /**
     * @var SelectItemEvent
     */
    protected $event;

    public function testDefaultConstructor()
    {
        $constructedEvent = new SelectItemEvent();

        $this->assertNotNull($constructedEvent);
        $this->assertEquals('select_item', $constructedEvent->getName());
    }

    public function testParameterConstructor()
    {
        $setParameters = [
            $this->faker->word => new BaseParameter($this->faker->word),
            $this->faker->word => new BaseParameter($this->faker->word)
        ];

        $constructedEvent = new ViewItemEvent($setParameters);

        $this->assertNotNull($constructedEvent);
        $this->assertEquals($setParameters, $constructedEvent->getParamList());
    }

    public function testValidateSuccess()
    {
        $newViewItemEvent = new ViewItemEvent();

        $this->assertTrue($newViewItemEvent->validate());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->event = new SelectItemEvent();
    }
}
