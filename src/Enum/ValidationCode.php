<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 24.06.2021
 * Time: 13:49
 */

namespace Br33f\Ga4\MeasurementProtocol\Enum;

class ValidationCode
{
    const VALUE_INVALID = 'VALUE_INVALID';
    const VALUE_REQUIRED = 'VALUE_REQUIRED';
    const NAME_INVALID = 'NAME_INVALID';
    const NAME_RESERVED = 'NAME_RESERVED';
    const VALUE_OUT_OF_BOUNDS = 'VALUE_OUT_OF_BOUNDS';
    const EXCEEDED_MAX_ENTITIES = 'EXCEEDED_MAX_ENTITIES';
    const NAME_DUPLICATED = 'NAME_DUPLICATED';
}