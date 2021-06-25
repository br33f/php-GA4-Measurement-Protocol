<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 25.06.2021
 * Time: 13:03
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Parameter;

use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\ItemParameter;
use Br33f\Ga4\MeasurementProtocol\Exception\ValidationException;
use Tests\Common\BaseTestCase;

class ItemParameterTest extends BaseTestCase
{
    protected $itemParameter;

    public function testDefaultConstructor()
    {
        $constructedItemParameter = new ItemParameter();

        $this->assertNotNull($constructedItemParameter);
    }

    public function testParametrizedConstructor()
    {
        $blueprint = [
            'item_id' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'quantity' => $this->faker->numberBetween(1, 3)
        ];
        $constructedItemParameter = new ItemParameter($blueprint);

        $this->assertNotNull($constructedItemParameter);
        $this->assertEquals($blueprint['item_id'], $constructedItemParameter->getItemId());
        $this->assertEquals($blueprint['price'], $constructedItemParameter->getPrice());
        $this->assertEquals($blueprint['quantity'], $constructedItemParameter->getQuantity());
    }

    public function testIndex()
    {
        $setIndex = $this->faker->numberBetween(1, 9);
        $this->itemParameter->setIndex($setIndex);

        $this->assertEquals($setIndex, $this->itemParameter->getIndex());
    }

    public function testAffiliation()
    {
        $setAffiliation = $this->faker->word;
        $this->itemParameter->setAffiliation($setAffiliation);

        $this->assertEquals($setAffiliation, $this->itemParameter->getAffiliation());
    }

    public function testCurrency()
    {
        $setCurrency = $this->faker->currencyCode;
        $this->itemParameter->setCurrency($setCurrency);

        $this->assertEquals($setCurrency, $this->itemParameter->getCurrency());
    }

    public function testQuantity()
    {
        $setQuantity = $this->faker->numberBetween(1, 30);
        $this->itemParameter->setQuantity($setQuantity);

        $this->assertEquals($setQuantity, $this->itemParameter->getQuantity());
    }

    public function testItemName()
    {
        $setName = $this->faker->word . $this->faker->colorName;
        $this->itemParameter->setItemName($setName);

        $this->assertEquals($setName, $this->itemParameter->getItemName());
    }

    public function testLocationId()
    {
        $setLocationId = $this->faker->bothify('*_#####');
        $this->itemParameter->setLocationId($setLocationId);

        $this->assertEquals($setLocationId, $this->itemParameter->getLocationId());
    }

    public function testItemCategory()
    {
        $setCategory = $this->faker->word;
        $this->itemParameter->setItemCategory($setCategory);
        $this->itemParameter->setItemCategory2($setCategory);
        $this->itemParameter->setItemCategory3($setCategory);
        $this->itemParameter->setItemCategory4($setCategory);
        $this->itemParameter->setItemCategory5($setCategory);

        $this->assertEquals($setCategory, $this->itemParameter->getItemCategory());
        $this->assertEquals($setCategory, $this->itemParameter->getItemCategory2());
        $this->assertEquals($setCategory, $this->itemParameter->getItemCategory3());
        $this->assertEquals($setCategory, $this->itemParameter->getItemCategory4());
        $this->assertEquals($setCategory, $this->itemParameter->getItemCategory5());
    }

    public function testPrice()
    {
        $setPrice = $this->faker->randomFloat(2, 1, 10000);
        $this->itemParameter->setPrice($setPrice);

        $this->assertEquals($setPrice, $this->itemParameter->getPrice());
    }

    public function testSetItemId()
    {
        $setItemId = $this->faker->bothify('***_#####');
        $this->itemParameter->setItemId($setItemId);

        $this->assertEquals($setItemId, $this->itemParameter->getItemId());
    }

    public function testItemListId()
    {
        $setItemListId = $this->faker->bothify('ITEM_LIST_#####');
        $this->itemParameter->setItemListId($setItemListId);

        $this->assertEquals($setItemListId, $this->itemParameter->getItemListId());
    }

    public function testItemListName()
    {
        $setItemListName = $this->faker->word;
        $this->itemParameter->setItemListName($setItemListName);

        $this->assertEquals($setItemListName, $this->itemParameter->getItemListName());
    }

    public function testCoupon()
    {
        $setCoupon = $this->faker->bothify('***-#####-#####');
        $this->itemParameter->setCoupon($setCoupon);

        $this->assertEquals($setCoupon, $this->itemParameter->getCoupon());
    }

    public function testDiscount()
    {
        $setDiscount = $this->faker->randomFloat(2, 1, 20);
        $this->itemParameter->setDiscount($setDiscount);

        $this->assertEquals($setDiscount, $this->itemParameter->getDiscount());
    }

    public function testItemVariant()
    {
        $setItemVariant = $this->faker->colorName;
        $this->itemParameter->setItemVariant($setItemVariant);

        $this->assertEquals($setItemVariant, $this->itemParameter->getItemVariant());
    }

    public function testSetItemBrand()
    {
        $setItemBrand = $this->faker->company;
        $this->itemParameter->setItemBrand($setItemBrand);

        $this->assertEquals($setItemBrand, $this->itemParameter->getItemBrand());
    }

    public function testValidateSuccess()
    {
        $validatedParameter = new ItemParameter(['item_name' => 'test1']);

        $this->assertTrue($validatedParameter->validate());
    }

    public function testValidateError()
    {
        $validatedParameter = new ItemParameter(['price' => 15.55]);

        $this->expectException(ValidationException::class);
        $validatedParameter->validate();
    }

    public function testHydrate()
    {
        $blueprint = [
            'item_id' => $this->faker->name,
            'item_name' => $this->faker->name,
            'affiliation' => $this->faker->name,
            'coupon' => $this->faker->name,
            'currency' => $this->faker->currencyCode,
            'discount' => $this->faker->randomFloat(2, 10, 30),
            'index' => $this->faker->numberBetween(1, 5),
            'item_brand' => $this->faker->company,
            'item_category' => $this->faker->name,
            'item_category2' => $this->faker->name,
            'item_category3' => $this->faker->name,
            'item_category4' => $this->faker->name,
            'item_category5' => $this->faker->name,
            'item_list_id' => $this->faker->name,
            'item_list_name' => $this->faker->name,
            'item_variant' => $this->faker->name,
            'location_id' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'quantity' => $this->faker->numberBetween(1, 3)
        ];

        $constructedItemParameter = new ItemParameter();
        $constructedItemParameter->hydrate($blueprint);

        $this->assertEquals($blueprint['item_id'], $constructedItemParameter->getItemId());
        $this->assertEquals($blueprint['item_name'], $constructedItemParameter->getItemName());
        $this->assertEquals($blueprint['affiliation'], $constructedItemParameter->getAffiliation());
        $this->assertEquals($blueprint['coupon'], $constructedItemParameter->getCoupon());
        $this->assertEquals($blueprint['currency'], $constructedItemParameter->getCurrency());
        $this->assertEquals($blueprint['discount'], $constructedItemParameter->getDiscount());
        $this->assertEquals($blueprint['index'], $constructedItemParameter->getIndex());
        $this->assertEquals($blueprint['item_brand'], $constructedItemParameter->getItemBrand());
        $this->assertEquals($blueprint['item_category'], $constructedItemParameter->getItemCategory());
        $this->assertEquals($blueprint['item_category2'], $constructedItemParameter->getItemCategory2());
        $this->assertEquals($blueprint['item_category3'], $constructedItemParameter->getItemCategory3());
        $this->assertEquals($blueprint['item_category4'], $constructedItemParameter->getItemCategory4());
        $this->assertEquals($blueprint['item_category5'], $constructedItemParameter->getItemCategory5());
        $this->assertEquals($blueprint['item_list_id'], $constructedItemParameter->getItemListId());
        $this->assertEquals($blueprint['item_list_name'], $constructedItemParameter->getItemListName());
        $this->assertEquals($blueprint['item_variant'], $constructedItemParameter->getItemVariant());
        $this->assertEquals($blueprint['location_id'], $constructedItemParameter->getLocationId());
        $this->assertEquals($blueprint['price'], $constructedItemParameter->getPrice());
        $this->assertEquals($blueprint['quantity'], $constructedItemParameter->getQuantity());
    }

    public function testExport()
    {
        $blueprint = [
            'item_id' => $this->faker->name,
            'item_name' => $this->faker->name,
            'affiliation' => $this->faker->name,
            'coupon' => $this->faker->name,
            'currency' => $this->faker->currencyCode,
            'discount' => $this->faker->randomFloat(2, 10, 30),
            'index' => $this->faker->numberBetween(1, 5),
            'item_brand' => $this->faker->company,
            'item_category' => $this->faker->name,
            'item_category2' => $this->faker->name,
            'item_category3' => $this->faker->name,
            'item_category4' => $this->faker->name,
            'item_category5' => $this->faker->name,
            'item_list_id' => $this->faker->name,
            'item_list_name' => $this->faker->name,
            'item_variant' => $this->faker->name,
            'location_id' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'quantity' => $this->faker->numberBetween(1, 3)
        ];

        $constructedItemParameter = new ItemParameter($blueprint);

        $this->assertEquals($blueprint, $constructedItemParameter->export());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->itemParameter = new ItemParameter();
    }
}
