<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 20.04.2024
 * Time: 12:09
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Common;

use Br33f\Ga4\MeasurementProtocol\Dto\Common\UserAddress;
use Br33f\Ga4\MeasurementProtocol\Dto\Common\UserDataItem;
use Tests\Common\BaseTestCase;

class UserAddressTest extends BaseTestCase
{
    /**
     * @var UserAddress
     */
    protected $userAddress;

    public function testDefaultConstructor()
    {
        $constructedUserAddress = new UserAddress();

        $this->assertEquals(null, $constructedUserAddress->getUserAddressItemList());
    }

    public function testConstructor()
    {
        $setUserDataItemList = [
            new UserDataItem(),
            new UserDataItem()
        ];
        $constructedUserAddress = new UserAddress($setUserDataItemList);

        $this->assertEquals($setUserDataItemList, $constructedUserAddress->getUserAddressItemList());
    }

    public function testAddUserAddressItem()
    {
        $userDataItem = new UserDataItem($this->faker->word, $this->faker->word);

        $this->userAddress->addUserAddressItem($userDataItem);

        $this->assertEquals([$userDataItem], $this->userAddress->getUserAddressItemList());
    }

    public function testSetUserAddressItemList()
    {
        $userAddressDatum1 = new UserDataItem($this->faker->word, $this->faker->word);
        $userAddressDatum2 = new UserDataItem($this->faker->word, $this->faker->word);

        $this->userAddress->setUserAddressItemList([$userAddressDatum1, $userAddressDatum2]);

        $this->assertEquals([$userAddressDatum1, $userAddressDatum2], $this->userAddress->getUserAddressItemList());
    }

    protected function setUp(): void
    {
        $this->userAddress = new UserAddress();
    }
}
