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
 * Class RefundEvent
 * @package Br33f\Ga4\MeasurementProtocol\Dto\Event
 * @method string getCurrency()
 * @method RefundEvent setCurrency(string $currency)
 * @method string getTransactionId()
 * @method RefundEvent setTransactionId(string $transactionId)
 * @method float getValue()
 * @method RefundEvent setValue(float $value)
 * @method string getAffiliation()
 * @method RefundEvent setAffiliation(string $affiliation)
 * @method string getCoupon()
 * @method RefundEvent setCoupon(string $coupon)
 * @method float getShipping()
 * @method RefundEvent setShipping(float $shipping)
 * @method float getTax()
 * @method RefundEvent setTax(float $tax)
 */
class RefundEvent extends ItemBaseEvent
{
    private $eventName = 'refund';

    /**
     * RefundEvent constructor.
     * @param AbstractParameter[] $paramList
     */
    public function __construct(array $paramList = [])
    {
        parent::__construct($this->eventName, $paramList);
    }

    public function validate()
    {
        parent::validate();

        if (empty($this->getTransactionId())) {
            throw new ValidationException('Field "transaction_id" is required if "value" is set', ErrorCode::VALIDATION_FIELD_REQUIRED, 'curtransaction_idrency');
        }

        if (!empty($this->getValue())) {
            if (empty($this->getCurrency())) {
                throw new ValidationException('Field "currency" is required if "value" is set', ErrorCode::VALIDATION_FIELD_REQUIRED, 'currency');
            }
        }

        return true;
    }
}