<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 25.06.2021
 * Time: 13:33
 */

namespace Br33f\Ga4\MeasurementProtocol\Dto\Event;

use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\AbstractParameter;

/**
 * Class ViewSearchResultsEvent
 * @package Br33f\Ga4\MeasurementProtocol\Dto\Event
 * @method string getSearchTerm()
 * @method ViewSearchResultsEvent setSearchTerm(string $itemListId)
 */
class ViewSearchResultsEvent extends ItemBaseEvent
{
    private $eventName = 'view_search_results';

    /**
     * ViewSearchResultsEvent constructor.
     * @param AbstractParameter[] $paramList
     */
    public function __construct(array $paramList = [])
    {
        parent::__construct($this->eventName, $paramList);
    }
}