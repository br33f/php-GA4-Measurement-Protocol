<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 25.06.2021
 * Time: 13:33
 */

namespace Br33f\Ga4\MeasurementProtocol\Dto\Event;

use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\AbstractParameter;

/**
 * Class ViewItemListEvent
 * @package Br33f\Ga4\MeasurementProtocol\Dto\Event
 * @method string getItemListId()
 * @method ViewItemListEvent setItemListId(string $itemListId)
 * @method string getItemListName()
 * @method ViewItemListEvent setItemListName(string $itemListName)
 */
class ViewItemListEvent extends ItemBaseEvent
{
    private $eventName = 'view_item_list';

    /**
     * ViewItemListEvent constructor.
     * @param AbstractParameter[] $paramList
     */
    public function __construct(array $paramList = [])
    {
        parent::__construct($this->eventName, $paramList);
    }
}