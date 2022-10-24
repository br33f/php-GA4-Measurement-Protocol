<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 22.06.2021
 * Time: 15:56
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Common;

use Br33f\Ga4\MeasurementProtocol\Dto\Common\UserProperties;
use Br33f\Ga4\MeasurementProtocol\Dto\Common\UserProperty;
use Tests\Common\BaseTestCase;

class UserPropertiesTest extends BaseTestCase
{
    /**
     * @var UserProperties
     */
    protected $userProperties;

    public function testDefaultConstructor()
    {
        $constructedUserProperties = new UserProperties();

        $this->assertEquals([], $constructedUserProperties->getUserPropertiesList());
    }

    public function testConstructor()
    {
        $setUserProperties = [
            new UserProperty(),
            new UserProperty()
        ];
        $constructedUserProperties = new UserProperties($setUserProperties);

        $this->assertEquals($setUserProperties, $constructedUserProperties->getUserPropertiesList());
    }

    public function testUserPropertiesList()
    {
        $setUserProperties = [
            new UserProperty($this->faker->word, $this->faker->word),
            new UserProperty($this->faker->word, $this->faker->word),
            new UserProperty($this->faker->word, $this->faker->word)
        ];

        $this->userProperties->setUserPropertiesList($setUserProperties);

        $this->assertEquals($setUserProperties, $this->userProperties->getUserPropertiesList());
    }

    public function testUserPropertyAdd()
    {
        $this->userProperties->setUserPropertiesList([]);

        $addUserProperty = new UserProperty($this->faker->word, $this->faker->word);
        $this->userProperties->addUserProperty($addUserProperty);

        $this->assertEquals(1, count($this->userProperties->getUserPropertiesList()));
        $this->assertEquals($addUserProperty, $this->userProperties->getUserPropertiesList()[0]);
    }

    public function testExport()
    {
        $setUserProperties = [
            new UserProperty($this->faker->word, $this->faker->word),
            new UserProperty($this->faker->word, $this->faker->word),
            new UserProperty($this->faker->word, $this->faker->word)
        ];

        $this->userProperties->setUserPropertiesList($setUserProperties);

        $this->assertEquals([
            $setUserProperties[0]->getName() => [
                'value' => $setUserProperties[0]->getValue()
            ],
            $setUserProperties[1]->getName() => [
                'value' => $setUserProperties[1]->getValue()
            ],
            $setUserProperties[2]->getName() => [
                'value' => $setUserProperties[2]->getValue()
            ],
        ], $this->userProperties->export());
}

    protected function setUp(): void
    {
        $this->userProperties = new UserProperties();
    }
}
