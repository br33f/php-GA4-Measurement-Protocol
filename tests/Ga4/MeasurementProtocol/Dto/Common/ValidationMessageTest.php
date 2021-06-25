<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 24.06.2021
 * Time: 13:54
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Common;

use Br33f\Ga4\MeasurementProtocol\Dto\Common\ValidationMessage;
use Br33f\Ga4\MeasurementProtocol\Enum\ValidationCode;
use Tests\Common\BaseTestCase;

class ValidationMessageTest extends BaseTestCase
{
    /**
     * @var ValidationMessage
     */
    protected $validationMessage;

    public function testDefaultConstructor()
    {
        $constructedValidationMessage = new ValidationMessage();

        $this->assertNotNull($constructedValidationMessage);
    }

    public function testArrayBlueprintConstructor()
    {
        $blueprint = ['fieldPath' => $this->faker->word];
        $constructedValidationMessage = new ValidationMessage($blueprint);

        $this->assertNotNull($constructedValidationMessage);
        $this->assertEquals($blueprint['fieldPath'], $constructedValidationMessage->getFieldPath());
        $this->assertEquals(null, $constructedValidationMessage->getDescription());
        $this->assertEquals(null, $constructedValidationMessage->getValidationCode());
    }

    public function testHydrate()
    {
        $blueprint = [
            'fieldPath' => $this->faker->word,
            'description' => $this->faker->text,
            'validationCode' => $this->faker->randomElement([ValidationCode::EXCEEDED_MAX_ENTITIES, ValidationCode::NAME_DUPLICATED, ValidationCode::NAME_RESERVED])
        ];
        $constructedValidationMessage = new ValidationMessage($blueprint);

        $this->assertNotNull($constructedValidationMessage);
        $this->assertEquals($blueprint['fieldPath'], $constructedValidationMessage->getFieldPath());
        $this->assertEquals($blueprint['description'], $constructedValidationMessage->getDescription());
        $this->assertEquals($blueprint['validationCode'], $constructedValidationMessage->getValidationCode());
    }

    public function testFieldPath()
    {
        $setFieldPath = $this->faker->word;
        $this->validationMessage->setFieldPath($setFieldPath);

        $this->assertEquals($setFieldPath, $this->validationMessage->getFieldPath());
    }

    public function testValidationCode()
    {
        $setValidationCode = $this->faker->randomElement([ValidationCode::EXCEEDED_MAX_ENTITIES, ValidationCode::NAME_DUPLICATED, ValidationCode::NAME_RESERVED]);
        $this->validationMessage->setValidationCode($setValidationCode);

        $this->assertEquals($setValidationCode, $this->validationMessage->getValidationCode());
    }

    public function testDescription()
    {
        $setDescription = $this->faker->text;
        $this->validationMessage->setDescription($setDescription);

        $this->assertEquals($setDescription, $this->validationMessage->getDescription());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->validationMessage = new ValidationMessage();
    }
}
