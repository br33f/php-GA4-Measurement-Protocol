<?php
/**
 * User: Alexis POUPELIN (AlexisPPLIN)
 * Date: 08.04.2024
 * Time: 11:00
 */

namespace Br33f\Ga4\MeasurementProtocol\Dto\Common;

use Br33f\Ga4\MeasurementProtocol\Dto\ExportableInterface;
use Br33f\Ga4\MeasurementProtocol\Enum\ConsentCode;

class ConsentProperty implements ExportableInterface
{
    /**
     * Sets consent for sending user data from the request's events and user properties to Google for advertising purposes.
     * @var ConsentCode
     */
    protected $ad_user_data;

    /**
     * Sets consent for personalized advertising for the user.
     * @var ConsentCode
     */
    protected $ad_personalization;

    /**
     * ConsentProperty constructor
     * @param ConsentCode|null $ad_user_data
     * @param ConsentCode|null $ad_personalization
     */
    public function __construct(?ConsentCode $ad_user_data = null, ?ConsentCode $ad_personalization = null)
    {
        $this->ad_user_data = $ad_user_data;
        $this->ad_personalization = $ad_personalization;
    }

    public function export() : array
    {
        $result = [];

        if (isset($this->ad_user_data)) {
            $result['ad_user_data'] = $this->ad_user_data;
        }

        if (isset($this->ad_personalization)) {
            $result['ad_personalization'] = $this->ad_personalization;
        }

        return $result;
    }

    /**
     * @return ConsentCode|null
     */
    public function getAdUserData() : ?ConsentCode
    {
        return $this->ad_user_data;
    }

    /**
     * @param ConsentCode|null $ad_user_data
     */
    public function setAdUserData(?ConsentCode $ad_user_data) : void
    {
        $this->ad_user_data = $ad_user_data;
    }

    /**
     * @return ConsentCode|null
     */
    public function getAdPersonalization() : ?ConsentCode
    {
        return $this->ad_personalization;
    }

    /**
     * @param ConsentCode|null $ad_personalization
     */
    public function setAdPersonalization(?ConsentCode $ad_personalization) : void
    {
        $this->ad_personalization = $ad_personalization;
    }
}