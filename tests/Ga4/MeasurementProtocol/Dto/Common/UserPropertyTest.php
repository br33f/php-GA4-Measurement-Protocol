<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 22.06.2021
 * Time: 15:47
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Common;

use Br33f\Ga4\MeasurementProtocol\Dto\Common\UserProperty;
use Tests\Common\BaseTestCase;

class UserPropertyTest extends BaseTestCase
{
    /**
     * @var UserProperty
     */
    protected $userProperty;

    public function testDefaultConstructor()
    {
        $constructedUserProperty = new UserProperty();

        $this->assertEquals(null, $constructedUserProperty->getName());
        $this->assertEquals(null, $constructedUserProperty->getValue());
    }

    public function testParametrizedConstructor()
    {
        $setName = $this->faker->word;
        $setValue = $this->faker->word;
        $constructedUserProperty = new UserProperty($setName, $setValue);

        $this->assertEquals($setName, $constructedUserProperty->getName());
        $this->assertEquals($setValue, $constructedUserProperty->getValue());
    }

    public function testName()
    {
        $setName = $this->faker->word;
        $this->userProperty->setName($setName);

        $this->assertEquals($setName, $this->userProperty->getName());
    }

    public function testValue()
    {
        $setValue = $this->faker->word;
        $this->userProperty->setValue($setValue);

        $this->assertEquals($setValue, $this->userProperty->getValue());
    }

    public function testExportEmpty()
    {
        $emptyUserProperty = new UserProperty();

        $this->assertEquals([null => ['value' => null]], $emptyUserProperty->export());
    }

    public function testExport()
    {
        $setName = $this->faker->word;
        $setValue = $this->faker->word;
        $emptyUserProperty = new UserProperty($setName, $setValue);

        $this->assertEquals([$setName => ['value' => $setValue]], $emptyUserProperty->export());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->userProperty = new UserProperty();
    }
}
