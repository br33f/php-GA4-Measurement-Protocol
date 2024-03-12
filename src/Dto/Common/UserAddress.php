<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 12.03.2024
 * Time: 16:31
 */

namespace Br33f\Ga4\MeasurementProtocol\Dto\Common;

class UserAddress extends UserData
{
    /**
     * UserAddress constructor.
     *
     * @param UserDataItem[] $addressUserDataItemList
     */
    public function __construct(array $addressUserDataItemList = null)
    {
        parent::__construct($addressUserDataItemList);
    }
}
