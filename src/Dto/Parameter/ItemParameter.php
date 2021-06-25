<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 24.06.2021
 * Time: 15:40
 */

namespace Br33f\Ga4\MeasurementProtocol\Dto\Parameter;

use Br33f\Ga4\MeasurementProtocol\Dto\HydratableInterface;
use Br33f\Ga4\MeasurementProtocol\Enum\ErrorCode;
use Br33f\Ga4\MeasurementProtocol\Exception\ValidationException;

/**
 * Class ItemParameter
 * @package Br33f\Ga4\MeasurementProtocol\Dto\Parameter
 */
class ItemParameter extends AbstractParameter implements HydratableInterface
{
    /**
     * The ID of the item
     * One of itemId or itemName is required.
     * @var string|null
     */
    protected $itemId;

    /**
     * The name of the item
     * One of itemId or itemName is required.
     * @var string|null
     */
    protected $itemName;

    /**
     * A product affiliation to designate a supplying company or brick and mortar store location
     * Not required
     * @var string|null
     */
    protected $affiliation;

    /**
     * The coupon name/code associated with the item
     * Not required
     * @var string|null
     */
    protected $coupon;

    /**
     * The currency in 3-lettery ISO 4217 format
     * Not required
     * @var string|null
     */
    protected $currency;

    /**
     * The monetary discount value associated with the item
     * Not required
     * @var float|null
     */
    protected $discount;

    /**
     * The index/position of the item in a list
     * Not required
     * @var float|null
     */
    protected $index;

    /**
     * The brand of the item
     * Not required
     * @var string|null
     */
    protected $itemBrand;

    /**
     * The category of the item.
     * If used as part of a category hierarchy or taxonomy then this will be the first category.
     * Not required
     * @var string|null
     */
    protected $itemCategory;

    /**
     * The second category of the item.
     * If used as part of a category hierarchy or taxonomy then this will be the first category.
     * Not required
     * @var string|null
     */
    protected $itemCategory2;

    /**
     * The third category of the item.
     * If used as part of a category hierarchy or taxonomy then this will be the first category.
     * Not required
     * @var string|null
     */
    protected $itemCategory3;

    /**
     * The fourth category of the item.
     * If used as part of a category hierarchy or taxonomy then this will be the first category.
     * Not required
     * @var string|null
     */
    protected $itemCategory4;

    /**
     * The fifth category of the item.
     * If used as part of a category hierarchy or taxonomy then this will be the first category.
     * Not required
     * @var string|null
     */
    protected $itemCategory5;

    /**
     * The ID of the list in which the item was presented to the user
     * Not required
     * @var string|null
     */
    protected $itemListId;

    /**
     * The name of the list in which the item was presented to the user
     * Not required
     * @var string|null
     */
    protected $itemListName;

    /**
     * The item variant or unique code or description for additional item details/options.
     * Not required
     * @var string|null
     */
    protected $itemVariant;

    /**
     * The location associated with the item. It's recommended to use the Google Place ID that corresponds to the associated item. A custom location ID can also be used
     * Not required
     * @var string|null
     */
    protected $locationId;

    /**
     * The monetary price of the item, in units of the specified currency parameter
     * Not required
     * @var float|null
     */
    protected $price;

    /**
     * Item quantity
     * Not required
     * @var float|null
     */
    protected $quantity;

    /**
     * ItemParameter constructor.
     * @param array|null $blueprint
     */
    public function __construct(?array $blueprint = null)
    {
        if ($blueprint !== null) {
            $this->hydrate($blueprint);
        }
    }

    /**
     * @param array $blueprint
     */
    public function hydrate($blueprint)
    {
        if (array_key_exists('item_id', $blueprint)) {
            $this->setItemId($blueprint['item_id']);
        }
        if (array_key_exists('item_name', $blueprint)) {
            $this->setItemName($blueprint['item_name']);
        }
        if (array_key_exists('affiliation', $blueprint)) {
            $this->setAffiliation($blueprint['affiliation']);
        }
        if (array_key_exists('coupon', $blueprint)) {
            $this->setCoupon($blueprint['coupon']);
        }
        if (array_key_exists('currency', $blueprint)) {
            $this->setCurrency($blueprint['currency']);
        }
        if (array_key_exists('discount', $blueprint)) {
            $this->setDiscount($blueprint['discount']);
        }
        if (array_key_exists('index', $blueprint)) {
            $this->setIndex($blueprint['index']);
        }
        if (array_key_exists('item_brand', $blueprint)) {
            $this->setItemBrand($blueprint['item_brand']);
        }
        if (array_key_exists('item_category', $blueprint)) {
            $this->setItemCategory($blueprint['item_category']);
        }
        if (array_key_exists('item_category2', $blueprint)) {
            $this->setItemCategory2($blueprint['item_category2']);
        }
        if (array_key_exists('item_category3', $blueprint)) {
            $this->setItemCategory3($blueprint['item_category3']);
        }
        if (array_key_exists('item_category4', $blueprint)) {
            $this->setItemCategory4($blueprint['item_category4']);
        }
        if (array_key_exists('item_category5', $blueprint)) {
            $this->setItemCategory5($blueprint['item_category5']);
        }
        if (array_key_exists('item_list_id', $blueprint)) {
            $this->setItemListId($blueprint['item_list_id']);
        }
        if (array_key_exists('item_list_name', $blueprint)) {
            $this->setItemListName($blueprint['item_list_name']);
        }
        if (array_key_exists('item_variant', $blueprint)) {
            $this->setItemVariant($blueprint['item_variant']);
        }
        if (array_key_exists('location_id', $blueprint)) {
            $this->setLocationId($blueprint['location_id']);
        }
        if (array_key_exists('price', $blueprint)) {
            $this->setPrice($blueprint['price']);
        }
        if (array_key_exists('quantity', $blueprint)) {
            $this->setQuantity($blueprint['quantity']);
        }
    }

    /**
     * @return bool
     * @throws ValidationException
     */
    public function validate()
    {
        if (empty($this->getItemId()) && empty($this->getItemName())) {
            throw new ValidationException("At least one of item_id or item_name is required", ErrorCode::VALIDATION_ITEM_AT_LEAST_ITEM_ID_OR_ITEM_NAME_REQUIRED, 'item_id|item_name');
        }

        return true;
    }

    /**
     * @return string|null
     */
    public function getItemId(): ?string
    {
        return $this->itemId;
    }

    /**
     * @param string|null $itemId
     * @return ItemParameter
     */
    public function setItemId(?string $itemId): ItemParameter
    {
        $this->itemId = $itemId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getItemName(): ?string
    {
        return $this->itemName;
    }

    /**
     * @param string|null $itemName
     * @return ItemParameter
     */
    public function setItemName(?string $itemName): ItemParameter
    {
        $this->itemName = $itemName;
        return $this;
    }

    /**
     * @return array
     */
    public function export()
    {
        $exportableObject = [
            'item_id' => $this->getItemId(),
            'item_name' => $this->getItemName(),
            'affiliation' => $this->getAffiliation(),
            'coupon' => $this->getCoupon(),
            'currency' => $this->getCurrency(),
            'discount' => $this->getDiscount(),
            'index' => $this->getIndex(),
            'item_brand' => $this->getItemBrand(),
            'item_category' => $this->getItemCategory(),
            'item_category2' => $this->getItemCategory2(),
            'item_category3' => $this->getItemCategory3(),
            'item_category4' => $this->getItemCategory4(),
            'item_category5' => $this->getItemCategory5(),
            'item_list_id' => $this->getItemListId(),
            'item_list_name' => $this->getItemListName(),
            'item_variant' => $this->getItemVariant(),
            'location_id' => $this->getLocationId(),
            'price' => $this->getPrice(),
            'quantity' => $this->getQuantity()
        ];

        $preparedExportableObject = [];

        foreach ($exportableObject as $exportableItemName => $exportableItemValue) {
            if (!is_null($exportableItemValue)) {
                $preparedExportableObject[$exportableItemName] = $exportableItemValue;
            }
        }

        return $preparedExportableObject;
    }

    /**
     * @return string|null
     */
    public function getAffiliation(): ?string
    {
        return $this->affiliation;
    }

    /**
     * @param string|null $affiliation
     * @return ItemParameter
     */
    public function setAffiliation(?string $affiliation): ItemParameter
    {
        $this->affiliation = $affiliation;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCoupon(): ?string
    {
        return $this->coupon;
    }

    /**
     * @param string|null $coupon
     * @return ItemParameter
     */
    public function setCoupon(?string $coupon): ItemParameter
    {
        $this->coupon = $coupon;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param string|null $currency
     * @return ItemParameter
     */
    public function setCurrency(?string $currency): ItemParameter
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    /**
     * @param float|null $discount
     * @return ItemParameter
     */
    public function setDiscount(?float $discount): ItemParameter
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getIndex(): ?float
    {
        return $this->index;
    }

    /**
     * @param float|null $index
     * @return ItemParameter
     */
    public function setIndex(?float $index): ItemParameter
    {
        $this->index = $index;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getItemBrand(): ?string
    {
        return $this->itemBrand;
    }

    /**
     * @param string|null $itemBrand
     * @return ItemParameter
     */
    public function setItemBrand(?string $itemBrand): ItemParameter
    {
        $this->itemBrand = $itemBrand;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getItemCategory(): ?string
    {
        return $this->itemCategory;
    }

    /**
     * @param string|null $itemCategory
     * @return ItemParameter
     */
    public function setItemCategory(?string $itemCategory): ItemParameter
    {
        $this->itemCategory = $itemCategory;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getItemCategory2(): ?string
    {
        return $this->itemCategory2;
    }

    /**
     * @param string|null $itemCategory2
     * @return ItemParameter
     */
    public function setItemCategory2(?string $itemCategory2): ItemParameter
    {
        $this->itemCategory2 = $itemCategory2;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getItemCategory3(): ?string
    {
        return $this->itemCategory3;
    }

    /**
     * @param string|null $itemCategory3
     * @return ItemParameter
     */
    public function setItemCategory3(?string $itemCategory3): ItemParameter
    {
        $this->itemCategory3 = $itemCategory3;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getItemCategory4(): ?string
    {
        return $this->itemCategory4;
    }

    /**
     * @param string|null $itemCategory4
     * @return ItemParameter
     */
    public function setItemCategory4(?string $itemCategory4): ItemParameter
    {
        $this->itemCategory4 = $itemCategory4;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getItemCategory5(): ?string
    {
        return $this->itemCategory5;
    }

    /**
     * @param string|null $itemCategory5
     * @return ItemParameter
     */
    public function setItemCategory5(?string $itemCategory5): ItemParameter
    {
        $this->itemCategory5 = $itemCategory5;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getItemListId(): ?string
    {
        return $this->itemListId;
    }

    /**
     * @param string|null $itemListId
     * @return ItemParameter
     */
    public function setItemListId(?string $itemListId): ItemParameter
    {
        $this->itemListId = $itemListId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getItemListName(): ?string
    {
        return $this->itemListName;
    }

    /**
     * @param string|null $itemListName
     * @return ItemParameter
     */
    public function setItemListName(?string $itemListName): ItemParameter
    {
        $this->itemListName = $itemListName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getItemVariant(): ?string
    {
        return $this->itemVariant;
    }

    /**
     * @param string|null $itemVariant
     * @return ItemParameter
     */
    public function setItemVariant(?string $itemVariant): ItemParameter
    {
        $this->itemVariant = $itemVariant;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    /**
     * @param string|null $locationId
     * @return ItemParameter
     */
    public function setLocationId(?string $locationId): ItemParameter
    {
        $this->locationId = $locationId;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     * @return ItemParameter
     */
    public function setPrice(?float $price): ItemParameter
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    /**
     * @param float|null $quantity
     * @return ItemParameter
     */
    public function setQuantity(?float $quantity): ItemParameter
    {
        $this->quantity = $quantity;
        return $this;
    }

}