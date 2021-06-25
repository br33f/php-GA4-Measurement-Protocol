<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 25.06.2021
 * Time: 13:25
 */

namespace Br33f\Ga4\MeasurementProtocol\Dto\Event;

use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\ItemCollectionParameter;
use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\ItemParameter;
use Br33f\Ga4\MeasurementProtocol\Exception\ValidationException;

/**
 * Class ItemBaseEvent
 * @package Br33f\Ga4\MeasurementProtocol\Dto\Event
 */
abstract class ItemBaseEvent extends AbstractEvent
{
    /**
     * @param ItemParameter $item
     * @return self
     */
    public function addItem(ItemParameter $item)
    {
        $this->getItems()->addItem($item);
        return $this;
    }

    /**
     * @return ItemCollectionParameter
     */
    public function getItems()
    {
        $items = $this->findParameter('items');

        if ($items === null) {
            $items = new ItemCollectionParameter();
            $this->setItems($items);
        }

        return $items;
    }

    /**
     * @param ItemCollectionParameter|null $items
     * @return self
     */
    public function setItems(?ItemCollectionParameter $items)
    {
        $this->deleteParameter('items');
        $this->addParam('items', $items);

        return $this;
    }

    /**
     * @return bool
     * @throws ValidationException
     */
    public function validate()
    {
        $this->getItems()->validate();

        return true;
    }
}