<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 24.06.2021
 * Time: 15:40
 */

namespace Br33f\Ga4\MeasurementProtocol\Dto\Parameter;

use Br33f\Ga4\MeasurementProtocol\Exception\ValidationException;

/**
 * Class ItemCollectionParameter
 * @package Br33f\Ga4\MeasurementProtocol\Dto\Parameter
 */
class ItemCollectionParameter extends AbstractParameter
{
    /**
     * @var ItemParameter[]
     */
    protected $itemList;

    /**
     * ItemCollectionParameter constructor.
     * @param ItemParameter[]|null $itemList
     */
    public function __construct(?array $itemList = [])
    {
        $this->itemList = $itemList;
    }

    /**
     * @param ItemParameter $item
     * @return ItemCollectionParameter
     */
    public function addItem(ItemParameter $item)
    {
        $this->itemList[] = $item;
        return $this;
    }

    /**
     * @return bool
     * @throws ValidationException
     */
    public function validate()
    {
        foreach ($this->getItemList() as $item) {
            $item->validate();
        }

        return true;
    }

    /**
     * @return ItemParameter[]
     */
    public function getItemList(): array
    {
        return $this->itemList;
    }

    /**
     * @param ItemParameter[] $itemList
     * @return ItemCollectionParameter
     */
    public function setItemList(array $itemList)
    {
        $this->itemList = $itemList;
        return $this;
    }

    /**
     * @return array
     */
    public function export()
    {
        $exportableObject = [];

        foreach ($this->getItemList() as $item) {
            $exportableObject[] = $item->export();
        }

        return $exportableObject;
    }
}