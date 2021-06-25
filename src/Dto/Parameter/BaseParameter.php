<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 22.06.2021
 * Time: 13:56
 */

namespace Br33f\Ga4\MeasurementProtocol\Dto\Parameter;

use Br33f\Ga4\MeasurementProtocol\Dto\ExportableInterface;

class BaseParameter extends AbstractParameter
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * BaseParameter constructor.
     * @param mixed|null $value
     */
    public function __construct($value = null)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function export()
    {
        if ($this->getValue() instanceof ExportableInterface) {
            return $this->getValue()->export();
        } else {
            return $this->getValue();
        }
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function validate()
    {
        return true;
    }
}