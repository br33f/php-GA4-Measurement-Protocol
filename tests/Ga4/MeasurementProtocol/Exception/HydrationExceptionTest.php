<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 23.06.2021
 * Time: 12:17
 */

namespace Tests\Ga4\MeasurementProtocol\Exception;

use Br33f\Ga4\MeasurementProtocol\Exception\HydrationException;
use Tests\Common\BaseTestCase;

class HydrationExceptionTest extends BaseTestCase
{
    public function test__construct()
    {
        $setMessage = $this->faker->word;
        $setCode = $this->faker->numerify('#######');
        $constructedValidationException = new HydrationException($setMessage, $setCode);

        $this->assertEquals($setMessage, $constructedValidationException->getMessage());
        $this->assertEquals($setCode, $constructedValidationException->getCode());
    }
}
