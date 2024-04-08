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
     * Must be either {@see ConsentCode::GRANTED} or {@see ConsentCode::DENIED}
     * @var string
     */
    protected $ad_user_data;

    /**
     * Sets consent for personalized advertising for the user.
     * Must be either {@see ConsentCode::GRANTED} or {@see ConsentCode::DENIED}
     * @var string
     */
    protected $ad_personalization;

    /**
     * ConsentProperty constructor
     * Each parameters must be either {@see ConsentCode::GRANTED} or {@see ConsentCode::DENIED}
     * @param string|null $ad_user_data 
     * @param string|null $ad_personalization
     */
    public function __construct(?string $ad_user_data = null, ?string $ad_personalization = null)
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
     * @return string|null
     */
    public function getAdUserData() : ?string
    {
        return $this->ad_user_data;
    }

    /**
     * Must be either {@see ConsentCode::GRANTED} or {@see ConsentCode::DENIED}
     * @param string|null $ad_user_data
     */
    public function setAdUserData(?string $ad_user_data) : void
    {
        $this->ad_user_data = $ad_user_data;
    }

    /**
     * @return string|null
     */
    public function getAdPersonalization() : ?string
    {
        return $this->ad_personalization;
    }

    /**
     * Must be either {@see ConsentCode::GRANTED} or {@see ConsentCode::DENIED}
     * @param string|null $ad_personalization
     */
    public function setAdPersonalization(?string $ad_personalization) : void
    {
        $this->ad_personalization = $ad_personalization;
    }
}