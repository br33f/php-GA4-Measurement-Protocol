<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 12.03.2024
 * Time: 16:31
 */

namespace Br33f\Ga4\MeasurementProtocol\Dto\Common;

use Br33f\Ga4\MeasurementProtocol\Dto\ExportableInterface;

class UserDataItem implements ExportableInterface
{
    /**
     * User property name
     * @var string
     */
    protected $name;

    /**
     * User property value
     * @var mixed
     */
    protected $value;

    /**
     * UserDataItem constructor.
     *
     * @param string|null $name
     * @param mixed $value
     */
    public function __construct(?string $name = null, $value = null)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function export() : array
    {
        $value = $this->getValue() instanceof ExportableInterface
            ? $this->getValue()->export()
            : $this->getValue();

        return [
            $this->getName() => $value,
        ];
    }

    /**
     * @return string|null
     */
    public function getName() : ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name)
    {
        $this->name = $name;
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
}
