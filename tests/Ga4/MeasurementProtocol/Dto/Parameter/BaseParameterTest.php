<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 22.06.2021
 * Time: 14:22
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Parameter;

use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\BaseParameter;
use Tests\Common\BaseTestCase;

class BaseParameterTest extends BaseTestCase
{
    /**
     * @var BaseParameter
     */
    protected $baseParameter;

    public function setUp(): void
    {
        $this->baseParameter = new BaseParameter();
    }

    public function testValueString()
    {
        $valueToSet = $this->faker->word;
        $this->baseParameter->setValue($valueToSet);

        $this->assertEquals($valueToSet, $this->baseParameter->getValue());
    }

    public function testValueArray()
    {
        $valueToSet = [];
        for ($i = 0; $i < $this->faker->randomDigit; $i++) {
            $valueToSet[] = $this->faker->word;
        }
        $this->baseParameter->setValue($valueToSet);

        $this->assertEquals($valueToSet, $this->baseParameter->getValue());
    }

    public function testValueBaseParam()
    {
        $valueToSet = new BaseParameter();
        $valueToSet->setValue($this->faker->word);
        $this->baseParameter->setValue($valueToSet);

        $this->assertEquals($valueToSet, $this->baseParameter->getValue());
    }

    public function testExportSimple()
    {
        $valueToSet = $this->faker->word;
        $this->baseParameter->setValue($valueToSet);

        $this->assertEquals($valueToSet, $this->baseParameter->export());
    }

    public function testExportBaseParameter()
    {
        $valueToSet = new BaseParameter();
        $valueToSet->setValue($this->faker->word);
        $this->baseParameter->setValue($valueToSet);

        $this->assertEquals($valueToSet->getValue(), $this->baseParameter->export());
    }
}
