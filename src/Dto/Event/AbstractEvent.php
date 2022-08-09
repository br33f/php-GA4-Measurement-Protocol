<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 22.06.2021
 * Time: 14:16
 */

namespace Br33f\Ga4\MeasurementProtocol\Dto\Event;

use BadMethodCallException;
use Br33f\Ga4\MeasurementProtocol\Dto\ExportableInterface;
use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\AbstractParameter;
use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\BaseParameter;
use Br33f\Ga4\MeasurementProtocol\Dto\ValidateInterface;
use InvalidArgumentException;

abstract class AbstractEvent implements ExportableInterface, ValidateInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var AbstractParameter[]
     */
    protected $paramList;

    /**
     * AbstractEvent constructor.
     * @param string|null $name
     * @param AbstractParameter[] $paramList
     */
    public function __construct(?string $name = null, array $paramList = [])
    {
        $this->name = $name;
        $this->paramList = $paramList ?? [];
    }

    /**
     * @param string $methodName
     * @param array $methodArguments
     * @return mixed|null
     */
    public function __call(string $methodName, array $methodArguments)
    {
        $methodPrefix = substr($methodName, 0, 3);
        $paramName = $this->convertCamelCaseToSnakeCase(substr($methodName, 3));
        if ($methodPrefix === "set") {
            if (!isset($methodArguments[0])) {
                throw new InvalidArgumentException('First argument is expected to be paramter value, none specified.');
            }
            return $this->setParamValue($paramName, $methodArguments[0]);
        }

        if ($methodPrefix === "get") {
            return $this->getParamValue($paramName);
        }

        throw new BadMethodCallException('Method ' . $methodName . ' is not defined.');
    }

    /**
     * @param string $input
     * @return string
     */
    protected function convertCamelCaseToSnakeCase(string $input)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }

    /**
     * @param string $paramName
     * @param mixed $paramValue
     * @return AbstractEvent
     */
    public function setParamValue(string $paramName, $paramValue)
    {
        $this->findOrCreateParameter($paramName)->setValue($paramValue);
        return $this;
    }

    /**
     * @param string $paramName
     * @return AbstractParameter
     */
    public function findOrCreateParameter(string $paramName)
    {
        $foundParameter = $this->findParameter($paramName);
        if ($foundParameter === null) {
            $foundParameter = new BaseParameter();
            $this->addParam($paramName, $foundParameter);
        }

        return $foundParameter;
    }

    /**
     * @param string $paramName
     * @return AbstractParameter|null
     */
    public function findParameter(string $paramName)
    {
        if (array_key_exists($paramName, $this->getParamList())) {
            return $this->getParamList()[$paramName];
        } else {
            return null;
        }
    }

    /**
     * @return AbstractParameter[]
     */
    public function getParamList(): array
    {
        return $this->paramList;
    }

    /**
     * @param AbstractParameter[] $paramList
     */
    public function setParamList(array $paramList)
    {
        $this->paramList = $paramList;
    }

    /**
     * @param string $parameterName
     * @param AbstractParameter $parameter
     */
    public function addParam(string $parameterName, AbstractParameter $parameter)
    {
        $this->paramList[$parameterName] = $parameter;
    }

    /**
     * @param string $paramName
     * @return mixed|null
     */
    public function getParamValue(string $paramName)
    {
        return $this->findOrCreateParameter($paramName)->getValue();
    }

    /**
     * @param string $paramName
     */
    public function deleteParameter(string $paramName)
    {
        if (array_key_exists($paramName, $this->getParamList())) {
            unset($this->paramList[$paramName]);
        }
    }

    public function export(): array
    {
        $preparedParams = [];
        foreach ($this->getParamList() as $parameterName => $parameter) {
            $parameterExportedValue = $parameter->export();
            if (!is_null($parameterExportedValue)) {
                $preparedParams[$parameterName] = $parameterExportedValue;
            }
        }

        return [
            'name' => $this->getName(),

            // Note that we need to return an \ArrayObject here. As otherwise json_encode will serialize params to `[]`. And
            // Google Analytics will error on this, as it expects a map. Whereas new \ArrayObject will export correctly to `{}`.
            // See https://github.com/br33f/php-GA4-Measurement-Protocol/issues/10.            
            'params' => new \ArrayObject($preparedParams),
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
    protected function setName(?string $name)
    {
        $this->name = $name;
    }
}