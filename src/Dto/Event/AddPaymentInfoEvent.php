<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 25.06.2021
 * Time: 13:33
 */

namespace Br33f\Ga4\MeasurementProtocol\Dto\Event;

use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\AbstractParameter;
use Br33f\Ga4\MeasurementProtocol\Enum\ErrorCode;
use Br33f\Ga4\MeasurementProtocol\Exception\ValidationException;

/**
 * Class AddPaymentInfoEvent
 * @package Br33f\Ga4\MeasurementProtocol\Dto\Event
 * @method string getCurrency()
 * @method AddPaymentInfoEvent setCurrency(string $currency)
 * @method float getValue()
 * @method AddPaymentInfoEvent setValue(float $value)
 * @method string getCoupon()
 * @method AddPaymentInfoEvent setCoupon(string $coupon)
 * @method string getPaymentType()
 * @method AddPaymentInfoEvent setPaymentType(string $paymentType)
 */
class AddPaymentInfoEvent extends ItemBaseEvent
{
    private $eventName = 'add_payment_info';

    /**
     * AddPaymentInfoEvent constructor.
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