<?php
/**
 * User: Alexis POUPELIN (AlexisPPLIN)
 * Date: 06.11.2023
 * Time: 17:00
 */

namespace Br33f\Ga4\MeasurementProtocol\Dto\Event;

use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\AbstractParameter;
use Br33f\Ga4\MeasurementProtocol\Enum\ErrorCode;
use Br33f\Ga4\MeasurementProtocol\Exception\ValidationException;

/**
 * Class AddToWishlistEvent
 * @package Br33f\Ga4\MeasurementProtocol\Dto\Event
 * @method string getCurrency()
 * @method AddToWishlistEvent setCurrency(string $currency)
 * @method float getValue()
 * @method AddToWishlistEvent setValue(float $value)
 */
class AddToWishlistEvent extends ItemBaseEvent
{
    private $eventName = 'add_to_wishlist';

    /**
     * AddToWishlistEvent constructor.
     * @param AbstractParameter[] $paramList
     */
    public function __construct(array $paramList = [])
    {
        parent::__construct($this->eventName, $paramList);
    }

    public function validate()
    {
        parent::validate();

        if (!empty($this->getValue())) {
            if (empty($this->getCurrency())) {
                throw new ValidationException('Field "currency" is required if "value" is set', ErrorCode::VALIDATION_FIELD_REQUIRED, 'currency');
            }
        }

        return true;
    }
}