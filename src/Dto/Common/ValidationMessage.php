<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 22.06.2021
 * Time: 12:23
 */

namespace Br33f\Ga4\MeasurementProtocol\Dto\Common;


use Br33f\Ga4\MeasurementProtocol\Dto\HydratableInterface;
use Br33f\Ga4\MeasurementProtocol\Enum\ValidationCode;
use Psr\Http\Message\ResponseInterface;

class ValidationMessage implements HydratableInterface
{
    /**
     * The path to the field that was invalid
     * @var string|null
     */
    protected $fieldPath;
    /**
     * A description of the error
     * @var string|null
     */
    protected $description;
    /**
     * A ValidationCode that corresponds to the error
     * @var string|null
     * @see ValidationCode
     */
    protected $validationCode;

    /**
     * ValidationMessage constructor.
     * @param array|null $blueprint
     */
    public function __construct(?array $blueprint = null)
    {
        if ($blueprint !== null) {
            $this->hydrate($blueprint);
        }
    }

    /**
     * @param array|ResponseInterface $blueprint
     */
    public function hydrate($blueprint)
    {
        $this->setFieldPath(array_key_exists('fieldPath', $blueprint) ? $blueprint['fieldPath'] : null);
        $this->setDescription(array_key_exists('description', $blueprint) ? $blueprint['description'] : null);
        $this->setValidationCode(array_key_exists('validationCode', $blueprint) ? $blueprint['validationCode'] : null);
    }

    /**
     * @return string|null
     */
    public function getFieldPath(): ?string
    {
        return $this->fieldPath;
    }

    /**
     * @param string|null $fieldPath
     */
    public function setFieldPath(?string $fieldPath)
    {
        $this->fieldPath = $fieldPath;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description)
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getValidationCode(): ?string
    {
        return $this->validationCode;
    }

    /**
     * @param string|null $validationCode
     */
    public function setValidationCode(?string $validationCode)
    {
        $this->validationCode = $validationCode;
    }
}