<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 22.06.2021
 * Time: 12:23
 */

namespace Br33f\Ga4\MeasurementProtocol\Dto\Common;


use Br33f\Ga4\MeasurementProtocol\Dto\ExportableInterface;

class UserProperty implements ExportableInterface
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
     * UserProperty constructor.
     * @param string|null $name
     * @param mixed $value
     */
    public function __construct(?string $name = null, $value = null)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function export(): array
    {
        return [
            $this->getName() => [
                'value' => $this->getValue()
            ]
        ];
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
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