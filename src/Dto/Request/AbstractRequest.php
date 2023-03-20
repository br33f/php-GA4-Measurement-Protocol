<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 22.06.2021
 * Time: 11:10
 */

namespace Br33f\Ga4\MeasurementProtocol\Dto\Request;


use Br33f\Ga4\MeasurementProtocol\Dto\ExportableInterface;
use Br33f\Ga4\MeasurementProtocol\Dto\RequestValidateInterface;

abstract class AbstractRequest implements ExportableInterface, RequestValidateInterface
{
}