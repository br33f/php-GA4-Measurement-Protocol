<?php
/**
 * User: Alexis POUPELIN (AlexisPPLIN)
 * Date: 08.04.2024
 * Time: 11:00
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Common;

use Br33f\Ga4\MeasurementProtocol\Dto\Common\ConsentProperty;
use Br33f\Ga4\MeasurementProtocol\Enum\ConsentCode;
use Tests\Common\BaseTestCase;

class ConsentPropertyTest extends BaseTestCase
{
    /**
     * @var ConsentProperty
     */
    protected $consentProperty;

    public function testDefaultConstructor()
    {
        $constructedConsentProperty = new ConsentProperty();

        $this->assertNull($constructedConsentProperty->getAdUserData());
        $this->assertNull($constructedConsentProperty->getAdPersonalization());
    }

    public function testParametrizedConstructor()
    {
        $ad_user_data = ConsentCode::DENIED;
        $ad_personalization = ConsentCode::GRANTED;
        $constructedConsentProperty = new ConsentProperty($ad_user_data, $ad_personalization);

        $this->assertEquals($ad_user_data, $constructedConsentProperty->getAdUserData());
        $this->assertEquals($ad_personalization, $constructedConsentProperty->getAdPersonalization());
    }

    public function testAdUserData()
    {
        $ad_user_data = ConsentCode::DENIED;
        $this->consentProperty->setAdUserData($ad_user_data);

        $this->assertEquals($ad_user_data, $this->consentProperty->getAdUserData());
    }

    public function testAdPersonalization()
    {
        $ad_personalization = ConsentCode::GRANTED;
        $this->consentProperty->setAdPersonalization($ad_personalization);

        $this->assertEquals($ad_personalization, $this->consentProperty->getAdPersonalization());
    }

    public function testExportEmpty()
    {
        $emptyConsentProperty = new ConsentProperty();

        $this->assertEquals([], $emptyConsentProperty->export());
    }

    public function testPartialExport()
    {
        $ad_user_data = ConsentCode::DENIED;
        $ad_personalization = null;
        $constructedConsentProperty = new ConsentProperty($ad_user_data, $ad_personalization);

        $this->assertEquals(['ad_user_data' => 'DENIED'], $constructedConsentProperty->export());
    }

    public function testExport()
    {
        $ad_user_data = ConsentCode::DENIED;
        $ad_personalization = ConsentCode::GRANTED;
        $constructedConsentProperty = new ConsentProperty($ad_user_data, $ad_personalization);

        $this->assertEquals(['ad_user_data' => 'DENIED', 'ad_personalization' => 'GRANTED'], $constructedConsentProperty->export());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->consentProperty = new ConsentProperty();
    }
}