<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 12.03.2024
 * Time: 16:31
 */

namespace Ga4\MeasurementProtocol\Dto\Common;

use Br33f\Ga4\MeasurementProtocol\Dto\Common\UserAddress;
use Br33f\Ga4\MeasurementProtocol\Dto\Common\UserData;
use Br33f\Ga4\MeasurementProtocol\Dto\Common\UserDataItem;
use Tests\Common\BaseTestCase;

class UserDataTest extends BaseTestCase
{
    /**
     * @var UserData
     */
    protected $userData;

    public function testDefaultConstructor()
    {
        $constructedUserData = new UserData();

        $this->assertEquals([], $constructedUserData->getUserDataItemList());
    }

    public function testConstructor()
    {
        $setUserDataItemList = [
            new UserDataItem(),
            new UserDataItem()
        ];
        $constructedUserData = new UserData($setUserDataItemList);

        $this->assertEquals($setUserDataItemList, $constructedUserData->getUserDataItemList());
    }

    public function testUserDataList()
    {
        $setUserDataItemList = [
            new UserDataItem($this->faker->word, $this->faker->word),
            new UserDataItem($this->faker->word, $this->faker->word),
            new UserDataItem($this->faker->word, $this->faker->word)
        ];

        $this->userData->setUserDataItemList($setUserDataItemList);

        $this->assertEquals($setUserDataItemList, $this->userData->getUserDataItemList());
    }

    public function testUserDataAdd()
    {
        $this->userData->setUserDataItemList([]);

        $addUserDataItem = new UserDataItem($this->faker->word, $this->faker->word);
        $this->userData->addUserDataItem($addUserDataItem);

        $this->assertEquals(1, count($this->userData->getUserDataItemList()));
        $this->assertEquals($addUserDataItem, $this->userData->getUserDataItemList()[0]);
    }

    public function testExport()
    {
        $setUserDataItem = [
            new UserDataItem($this->faker->word, $this->faker->word),
            new UserDataItem($this->faker->word, $this->faker->word),
            new UserDataItem($this->faker->word, $this->faker->word)
        ];

        $this->userData->setUserDataItemList($setUserDataItem);

        $this->assertEquals([
            $setUserDataItem[0]->getName() => $setUserDataItem[0]->getValue(),
            $setUserDataItem[1]->getName() => $setUserDataItem[1]->getValue(),
            $setUserDataItem[2]->getName() => $setUserDataItem[2]->getValue(),
        ], $this->userData->export());
    }

    public function testExportAddress()
    {
        $userAddressDatum1 = new UserDataItem($this->faker->word, $this->faker->word);
        $userAddressDatum2 = new UserDataItem($this->faker->word, $this->faker->word);
        $userAddress = new UserAddress([$userAddressDatum1, $userAddressDatum2]);
        $this->userData->setUserAddressList([$userAddress]);

        $this->assertEquals([
            'address' => [
                [
                    $userAddressDatum1->getName() => $userAddressDatum1->getValue(),
                    $userAddressDatum2->getName() => $userAddressDatum2->getValue(),
                ],
            ]
        ], $this->userData->export());
    }

    public function testAddUserAddress()
    {
        $userAddressDatum1 = new UserDataItem($this->faker->word, $this->faker->word);
        $userAddressDatum2 = new UserDataItem($this->faker->word, $this->faker->word);
        $userAddress = new UserAddress([$userAddressDatum1, $userAddressDatum2]);

        $this->userData->addUserAddress($userAddress);

        $this->assertEquals([
            'address' => [
                [
                    $userAddressDatum1->getName() => $userAddressDatum1->getValue(),
                    $userAddressDatum2->getName() => $userAddressDatum2->getValue(),
                ],
            ]
        ], $this->userData->export());
    }

    protected function setUp(): void
    {
        $this->userData = new UserData();
    }
}
