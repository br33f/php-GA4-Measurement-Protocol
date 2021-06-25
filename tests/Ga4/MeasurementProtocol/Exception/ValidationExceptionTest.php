<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 23.06.2021
 * Time: 12:17
 */

namespace Tests\Ga4\MeasurementProtocol\Exception;

use Br33f\Ga4\MeasurementProtocol\Exception\ValidationException;
use Tests\Common\BaseTestCase;

class ValidationExceptionTest extends BaseTestCase
{
    public function test__construct()
    {
        $setMessage = $this->faker->word;
        $setCode = $this->faker->numerify('#######');
        $setFieldName = $this->faker->word;
        $constructedValidationException = new ValidationException($setMessage, $setCode, $setFieldName);

        $this->assertEquals($setMessage, $constructedValidationException->getMessage());
        $this->assertEquals($setCode, $constructedValidationException->getCode());
        $this->assertEquals($setFieldName, $constructedValidationException->getFieldName());
    }

    public function testFieldName()
    {
        $setFieldName = $this->faker->word;

        $constructedValidationException = new ValidationException();
        $constructedValidationException->setFieldName($setFieldName);

        $this->assertEquals($setFieldName, $constructedValidationException->getFieldName());
    }

}
