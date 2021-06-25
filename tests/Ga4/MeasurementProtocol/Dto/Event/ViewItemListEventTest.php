<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 25.06.2021
 * Time: 10:44
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Event;

use Br33f\Ga4\MeasurementProtocol\Dto\Event\ViewItemEvent;
use Br33f\Ga4\MeasurementProtocol\Dto\Event\ViewItemListEvent;
use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\BaseParameter;
use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\ItemCollectionParameter;
use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\ItemParameter;
use Tests\Common\BaseTestCase;

class ViewItemListEventTest extends BaseTestCase
{
    /**
     * @var ViewItemEvent
     */
    protected $event;

    public function testDefaultConstructor()
    {
        $constructedEvent = new ViewItemListEvent();

        $this->assertNotNull($constructedEvent);
        $this->assertEquals('view_item_list', $constructedEvent->getName());
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

    public function testSetGetItems()
    {
        $setItems = new ItemCollectionParameter([
            new ItemParameter(['item_name' => $this->faker->word]),
            new ItemParameter(['item_name' => $this->faker->word, 'price' => $this->faker->randomFloat(2, 10, 100)])
        ]);

        $this->event->setItems($setItems);

        $this->assertEquals($setItems, $this->event->getItems());
    }

    public function testGetItemsEmpty()
    {
        $newViewItemEvent = new ViewItemEvent();

        $this->assertNotNull($newViewItemEvent->getItems());
    }

    public function testAddItem()
    {
        $this->event->setItems(new ItemCollectionParameter());

        $itemToAdd = new ItemParameter(['item_name' => $this->faker->word]);
        $this->event->addItem($itemToAdd);

        $this->assertEquals(1, count($this->event->getItems()->getItemList()));
        $this->assertEquals($itemToAdd, $this->event->getItems()->getItemList()[0]);
    }

    public function testCurrency()
    {
        $setCurrency = $this->faker->currencyCode;
        $this->event->setCurrency($setCurrency);

        $this->assertEquals($setCurrency, $this->event->getCurrency());
    }

    public function testValue()
    {
        $setValue = $this->faker->randomFloat(2, 10, 2000);
        $this->event->setValue($setValue);

        $this->assertEquals($setValue, $this->event->getValue());
    }

    public function testValidate()
    {
        $newViewItemEvent = new ViewItemEvent();

        $this->assertTrue($newViewItemEvent->validate());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->event = new ViewItemListEvent();
    }
}
