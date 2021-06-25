<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 25.06.2021
 * Time: 13:52
 */

namespace Br33f\Ga4\MeasurementProtocol\Dto\Event;

use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\AbstractParameter;

/**
 * Class LoginEvent
 * @package Br33f\Ga4\MeasurementProtocol\Dto\Event
 * @method string getMethod()
 * @method LoginEvent setMethod(string $method)
 */
class LoginEvent extends AbstractEvent
{
    private $eventName = 'login';

    /**
     * LoginEvent constructor.
     * @param AbstractParameter[] $paramList
     */
    public function __construct(array $paramList = [])
    {
        parent::__construct($this->eventName, $paramList);
    }

    /**
     * @return bool
     */
    public function validate()
    {
        return true;
    }
}