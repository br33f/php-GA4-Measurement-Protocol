<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 22.06.2021
 * Time: 14:22
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Parameter;

use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\ItemCollectionParameter;
use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\ItemParameter;
use Br33f\Ga4\MeasurementProtocol\Exception\ValidationException;
use Tests\Common\BaseTestCase;

class ItemCollectionParameterTest extends BaseTestCase
{
    /**
     * @var ItemCollectionParameter
     */
    protected $itemCollectionParameter;

    public function setUp(): void
    {
        $this->itemCollectionParameter = new ItemCollectionParameter();
    }

    public function testDefaultContructor()
    {
        $constructedItemCollectionParameter = new ItemCollectionParameter();

        $this->assertNotNull($constructedItemCollectionParameter);
    }

    public function testItemList()
    {
        $setItemList = [
            new ItemParameter(['item_name' => 'test1']),
            new ItemParameter(['item_id' => '123', 'price' => 15.55])
        ];
        $this->itemCollectionParameter->setItemList($setItemList);

        $this->assertEquals($setItemList, $this->itemCollectionParameter->getItemList());
    }

    public function testAddItem()
    {
        $itemToAdd = new ItemParameter(['item_name' => $this->faker->name, 'item_id' => '123', 'price' => 15.55]);
        $this->itemCollectionParameter
            ->setItemList([])
            ->addItem($itemToAdd);

        $this->assertEquals(1, count($this->itemCollectionParameter->getItemList()));
        $this->assertEquals($itemToAdd, $this->itemCollectionParameter->getItemList()[0]);
    }

    public function testExportSimple()
    {
        $setItemList = [
            new ItemParameter(['item_name' => 'test1']),
            new ItemParameter(['item_id' => '123', 'price' => 15.55])
        ];
        $this->itemCollectionParameter->setItemList($setItemList);

        $this->assertEquals([
            ['item_name' => 'test1'],
            ['item_id' => '123', 'price' => 15.55]
        ], $this->itemCollectionParameter->export());
    }

    public function testValidateSuccess()
    {
        $setItemList = [
            new ItemParameter(['item_name' => 'test1']),
            new ItemParameter(['item_id' => '123', 'price' => 15.55])
        ];
        $this->itemCollectionParameter->setItemList($setItemList);

        $this->assertTrue($this->itemCollectionParameter->validate());
    }

    public function testValidateError()
    {
        $setItemList = [
            new ItemParameter(['item_name' => 'test1']),
            new ItemParameter(['price' => 15.55])
        ];
        $this->itemCollectionParameter->setItemList($setItemList);

        $this->expectException(ValidationException::class);
        $this->itemCollectionParameter->validate();
    }
}
