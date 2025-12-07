<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 12.03.2024
 * Time: 16:31
 */

namespace Br33f\Ga4\MeasurementProtocol\Dto\Common;

use Br33f\Ga4\MeasurementProtocol\Dto\ExportableInterface;

class UserData implements ExportableInterface
{
    /**
     * @var UserDataItem[]
     */
    protected $userDataItemList;

    /**
     * @var UserAddress[]|null
     */
    protected $userAddressList;

    /**
     * UserData constructor.
     *
     * @param UserDataItem[] $userDataItemList
     * @param UserAddress[]  $userAddressList
     */
    public function __construct(?array $userDataItemList = null, ?array $userAddressList = null)
    {
        $this->userDataItemList = $userDataItemList ?? [];
        $this->userAddressList = $userAddressList;
    }

    /**
     * @param UserDataItem $userDataItem
     */
    public function addUserDataItem(UserDataItem $userDataItem)
    {
        $this->userDataItemList[] = $userDataItem;
    }

    /**
     * @param UserAddress $userAddress
     */
    public function addUserAddress(UserAddress $userAddress)
    {
        if ($this->getUserAddressList() === null) {
            $this->setUserAddressList([]);
        }

        $this->userAddressList[] = $userAddress;
    }

    /**
     * @return array
     */
    public function export() : array
    {
        $userDataExport = array_reduce($this->getUserDataItemList(), function ($last, UserDataItem $userDataItem) {
            return array_merge($last, $userDataItem->export());
        }, []);

        if ($this->getUserAddressList() !== null) {
            $userDataExport['address'] = array_map(function (UserAddress $userAddress) {
                return $userAddress->export();
            }, $this->getUserAddressList());
        }

        return $userDataExport;
    }

    /**
     * @return UserDataItem[]
     */
    public function getUserDataItemList() : array
    {
        return $this->userDataItemList;
    }

    /**
     * @param UserDataItem[] $userDataItemList
     */
    public function setUserDataItemList(array $userDataItemList)
    {
        $this->userDataItemList = $userDataItemList;
    }

    /**
     * @return UserAddress[]|null
     */
    public function getUserAddressList() : ?array
    {
        return $this->userAddressList;
    }

    /**
     * @param UserAddress[] $userAddressList
     */
    public function setUserAddressList(array $userAddressList)
    {
        $this->userAddressList = $userAddressList;
    }
}
