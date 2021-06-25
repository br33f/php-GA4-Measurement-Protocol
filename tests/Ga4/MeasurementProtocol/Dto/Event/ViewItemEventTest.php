<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 25.06.2021
 * Time: 10:44
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Event;

use Br33f\Ga4\MeasurementProtocol\Dto\Event\ViewItemEvent;
use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\BaseParameter;
use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\ItemCollectionParameter;
use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\ItemParameter;
use Tests\Common\BaseTestCase;

class ViewItemEventTest extends BaseTestCase
{
    protected $viewItemEvent;

    public function testDefaultConstructor()
    {
        $constructedEvent = new ViewItemEvent();

        $this->assertNotNull($constructedEvent);
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

        $this->viewItemEvent->setItems($setItems);

        $this->assertEquals($setItems, $this->viewItemEvent->getItems());
    }

    public function testGetItemsEmpty()
    {
        $newViewItemEvent = new ViewItemEvent();

        $this->assertNotNull($newViewItemEvent->getItems());
    }

    public function testAddItem()
    {
        $this->viewItemEvent->setItems(new ItemCollectionParameter());

        $itemToAdd = new ItemParameter(['item_name' => $this->faker->word]);
        $this->viewItemEvent->addItem($itemToAdd);

        $this->assertEquals(1, count($this->viewItemEvent->getItems()->getItemList()));
        $this->assertEquals($itemToAdd, $this->viewItemEvent->getItems()->getItemList()[0]);
    }

    public function testCurrency()
    {
        $setCurrency = $this->faker->currencyCode;
        $this->viewItemEvent->setCurrency($setCurrency);

        $this->assertEquals($setCurrency, $this->viewItemEvent->getCurrency());
    }

    public function testValue()
    {
        $setValue = $this->faker->randomFloat(2, 10, 2000);
        $this->viewItemEvent->setValue($setValue);

        $this->assertEquals($setValue, $this->viewItemEvent->getValue());
    }

    public function testValidateEmpty()
    {
        $newViewItemEvent = new ViewItemEvent();

        $this->assertTrue($newViewItemEvent->validate());
    }

    public function testValidate()
    {
        $setItems = new ItemCollectionParameter([
            new ItemParameter(['item_name' => $this->faker->word]),
            new ItemParameter(['item_name' => $this->faker->word, 'price' => $this->faker->randomFloat(2, 10, 100)])
        ]);
        $newViewItemEvent = new ViewItemEvent([$setItems]);

        $this->assertTrue($newViewItemEvent->validate());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->viewItemEvent = new ViewItemEvent();
    }
}
