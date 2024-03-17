<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 12.03.2024
 * Time: 16:31
 */

namespace Ga4\MeasurementProtocol\Dto\Common;

use Br33f\Ga4\MeasurementProtocol\Dto\Common\UserDataItem;
use Tests\Common\BaseTestCase;

class UserDataItemTest extends BaseTestCase
{
    /**
     * @var UserDataItem
     */
    protected $userDataItem;

    public function testDefaultConstructor()
    {
        $constructedUserDataItem = new UserDataItem();

        $this->assertEquals(null, $constructedUserDataItem->getName());
        $this->assertEquals(null, $constructedUserDataItem->getValue());
    }

    public function testParametrizedConstructor()
    {
        $setName = $this->faker->word;
        $setValue = $this->faker->word;
        $constructedUserDataItem = new UserDataItem($setName, $setValue);

        $this->assertEquals($setName, $constructedUserDataItem->getName());
        $this->assertEquals($setValue, $constructedUserDataItem->getValue());
    }

    public function testName()
    {
        $setName = $this->faker->word;
        $this->userDataItem->setName($setName);

        $this->assertEquals($setName, $this->userDataItem->getName());
    }

    public function testValue()
    {
        $setValue = $this->faker->word;
        $this->userDataItem->setValue($setValue);

        $this->assertEquals($setValue, $this->userDataItem->getValue());
    }

    public function testExportNested()
    {
        $rootName = 'root';
        $nestedName = 'nested';
        $nestedValue = 'nvalue';

        $nestedUserDataItem = new UserDataItem($nestedName, $nestedValue);
        $userDataItem = new UserDataItem($rootName, $nestedUserDataItem);

        $this->assertEquals([$rootName => [$nestedName => $nestedValue]], $userDataItem->export());
    }

    public function testExportEmpty()
    {
        $emptyUserDataItem = new UserDataItem();

        $this->assertEquals([null => null], $emptyUserDataItem->export());
    }

    public function testExport()
    {
        $setName = $this->faker->word;
        $setValue = $this->faker->word;
        $emptyUserDataItem = new UserDataItem($setName, $setValue);

        $this->assertEquals([$setName => $setValue], $emptyUserDataItem->export());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->userDataItem = new UserDataItem();
    }
}
