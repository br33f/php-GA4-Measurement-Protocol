<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 21.06.2021
 * Time: 16:15
 */

namespace Br33f\Ga4\MeasurementProtocol;

use Br33f\Ga4\MeasurementProtocol\Dto\Request\AbstractRequest;
use Br33f\Ga4\MeasurementProtocol\Dto\Response\BaseResponse;
use Br33f\Ga4\MeasurementProtocol\Dto\Response\DebugResponse;

class Service
{
    const SSL_SCHEME = 'https://';
    const NOT_SSL_SCHEME = 'http://';

    /**
     * Indicates if connection to endpoint should be made with HTTPS (true) or HTTP (false)
     * @var bool
     */
    protected $useSsl = true;

    /**
     * Collect Endpoint
     * @var string
     */
    protected $collectEndpoint = 'google-analytics.com/mp/collect';

    /**
     * Collect Debug Endpoint. Used for validating events.
     * @var string
     */
    protected $collectDebugEndpoint = 'google-analytics.com/debug/mp/collect';

    /**
     * Http Client
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * An API SECRET generated in the Google Analytics UI
     * @var string
     */
    protected $apiSecret;

    /**
     * The measurement ID associated with a data stream
     * @var string
     */
    protected $measurementId;

    /**
     * Http Options
     * @var array
     */
    protected $options;

    /**
     * Client constructor.
     * @param string $apiSecret
     * @param string $measurementId
     */
    public function __construct(string $apiSecret, string $measurementId)
    {
        $this->setApiSecret($apiSecret);
        $this->setMeasurementId($measurementId);
    }

    /**
     * @param AbstractRequest $request
     * @return BaseResponse
     * @throws Exception\ValidationException
     * @throws Exception\HydrationException
     */
    public function send(AbstractRequest $request)
    {
        $request->validate();
        $response = $this->getHttpClient()->post($this->getEndpoint(), $request->export(), $this->getOptions());

        return new BaseResponse($response);
    }

    /**
     * Returns Http Client if set or creates a new instance and returns it
     * @return HttpClient
     */
    public function getHttpClient(): HttpClient
    {
        if ($this->httpClient === null) {
            $this->httpClient = new HttpClient();
        }
        return $this->httpClient;
    }

    /**
     * @param HttpClient $httpClient
     */
    public function setHttpClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Returns prepared endpoint url
     * @return string
     */
    public function getEndpoint(?bool $isDebug = false): string
    {
        $protocolScheme = $this->isUseSsl() ? self::SSL_SCHEME : self::NOT_SSL_SCHEME;
        $collectEndpoint = $isDebug ? $this->getCollectDebugEndpoint() : $this->getCollectEndpoint();
        return $protocolScheme . $collectEndpoint . "?" . http_build_query(['measurement_id' => $this->getMeasurementId(), 'api_secret' => $this->getApiSecret()]);
    }

    /**
     * @return bool
     */
    public function isUseSsl(): bool
    {
        return $this->useSsl;
    }

    /**
     * @param bool $useSsl
     */
    public function setUseSsl(bool $useSsl)
    {
        $this->useSsl = $useSsl;
    }

    /**
     * @return string
     */
    public function getCollectDebugEndpoint(): string
    {
        return $this->collectDebugEndpoint;
    }

    /**
     * @param string $collectDebugEndpoint
     */
    public function setCollectDebugEndpoint(string $collectDebugEndpoint)
    {
        $this->collectDebugEndpoint = $collectDebugEndpoint;
    }

    /**
     * @return string
     */
    public function getCollectEndpoint(): string
    {
        return $this->collectEndpoint;
    }

    /**
     * @param string $collectEndpoint
     */
    public function setCollectEndpoint(string $collectEndpoint)
    {
        $this->collectEndpoint = $collectEndpoint;
    }

    /**
     * @return string
     */
    public function getMeasurementId(): string
    {
        return $this->measurementId;
    }

    /**
     * @param string $measurementId
     */
    public function setMeasurementId(string $measurementId)
    {
        $this->measurementId = $measurementId;
    }

    /**
     * @return string
     */
    public function getApiSecret(): string
    {
        return $this->apiSecret;
    }

    /**
     * @param string $apiSecret
     */
    public function setApiSecret(string $apiSecret)
    {
        $this->apiSecret = $apiSecret;
    }

    /**
     * @return array|null
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * @param array|null $options
     */
    public function setOptions(?array $options)
    {
        $this->options = $options;
    }

    /**
     * @param AbstractRequest $request
     * @return BaseResponse
     * @throws Exception\ValidationException
     * @throws Exception\HydrationException
     */
    public function sendDebug(AbstractRequest $request)
    {
        $request->validate();
        $response = $this->getHttpClient()->post($this->getEndpoint(true), $request->export(), $this->getOptions());

        return new DebugResponse($response);
    }
}