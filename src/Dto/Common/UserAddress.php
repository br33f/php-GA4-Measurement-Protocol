<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 12.03.2024
 * Time: 16:31
 */

namespace Br33f\Ga4\MeasurementProtocol\Dto\Common;

use Br33f\Ga4\MeasurementProtocol\Dto\ExportableInterface;

class UserAddress implements ExportableInterface
{
    /**
     * @var UserAddress[]|null
     */
    protected $userAddressItemList;

    /**
     * UserAddress constructor.
     *
     * @param UserAddress[]  $userAddressList
     */
    public function __construct(array $userAddressItemList = null)
    {
        $this->userAddressItemList = $userAddressItemList;
    }

    /**
     * @param UserDataItem $userAddressItem
     */
    public function addUserAddressItem(UserDataItem $userAddressItem)
    {
        $this->userAddressItemList[] = $userAddressItem;
    }

    /**
     * @return array
     */
    public function export() : array
    {
        $userAddressExport = array_reduce($this->getUserAddressItemList(), function ($last, UserDataItem $userAddressItem) {
            return array_merge($last, $userAddressItem->export());
        }, []);

        return $userAddressExport;
    }

    /**
     * @return UserAddress[]|null
     */
    public function getUserAddressItemList() : ?array
    {
        return $this->userAddressItemList;
    }

    /**
     * @param UserAddress[] $userAddressItemList
     */
    public function setUserAddressItemList(array $userAddressItemList)
    {
        $this->userAddressItemList = $userAddressItemList;
    }
}
