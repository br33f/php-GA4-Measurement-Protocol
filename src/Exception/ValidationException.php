<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 22.06.2021
 * Time: 11:20
 */

namespace Br33f\Ga4\MeasurementProtocol\Exception;

use Exception;
use Throwable;

class ValidationException extends AnalyticsException
{
    /**
     * @var string|null
     */
    protected $fieldName = null;

    public function __construct($message = "", $code = 0, $fieldName = null, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->fieldName = $fieldName;
    }

    /**
     * @return string|null
     */
    public function getFieldName(): ?string
    {
        return $this->fieldName;
    }

    /**
     * @param string|null $fieldName
     */
    public function setFieldName(?string $fieldName): void
    {
        $this->fieldName = $fieldName;
    }
}