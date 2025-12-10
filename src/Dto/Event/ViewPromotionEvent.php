<?php
/**
 * User: https://github.com/ldani3l
 * Date: 09.12.2025
 * Time: 15:22
 */

namespace Br33f\Ga4\MeasurementProtocol\Dto\Event;

use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\AbstractParameter;

/**
 * Class ViewPromotionEvent
 * @package Br33f\Ga4\MeasurementProtocol\Dto\Event
 * @method string getPromotionId()
 * @method ItemParameter setPromotionId(string $promotionId)
 * @method string getPromotionName()
 * @method ItemParameter setPromotionName(string $itemListName)
 */
class ViewPromotionEvent extends ItemBaseEvent
{
    private $eventName = 'view_promotion';

    /**
     * ViewItemEvent constructor.
     * @param AbstractParameter[] $paramList
     */
    public function __construct(array $paramList = [])
    {
        parent::__construct($this->eventName, $paramList);
    }
}
