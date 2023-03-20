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
use Br33f\Ga4\MeasurementProtocol\Exception\MisconfigurationException;

class Service
{
    const SSL_SCHEME = 'https://';
    const NOT_SSL_SCHEME = 'http://';
    const PREPENDED_WWW = 'www';

    /**
     * Indicates if connection to endpoint should be made with HTTPS (true) or HTTP (false)
     * @var bool
     */
    protected $useSsl = true;

    /**
     * Indicates if connection to endpoint should be made with prepended WWW
     * @var bool
     */
    protected $useWww = false;

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
    protected $apiSecret = null;

    /**
     * The measurement ID associated with a data stream
     * @var string
     */
    protected $measurementId = null;

    /**
     * The Firebase App ID associated with a data stream
     * @var string
     */
    protected $firebaseId = null;
    
    /**
     * The custom ip address of the visitor
     * @var string
     */
    protected $ipOverride;

    /**
     * Http Options
     * @var array
     */
    protected $options;

    /**
     * Client constructor.
     * @param string $apiSecret
     * @param string|null $measurementId
     */
    public function __construct(string $apiSecret, ?string $measurementId = null)
    {
        $this->setApiSecret($apiSecret);
        if ($measurementId) {
          @trigger_error('Creating a measurement service instance with a measurement ID passed to the constructor is deprecated in v0.1.3 and removed in v0.2.0. Use ::setMeasurementId() or ::setFirebaseId() directly, instead.', E_USER_DEPRECATED);
          $this->setMeasurementId($measurementId);
        }
    }

    /**
     * @param AbstractRequest $request
     * @param bool|null $debug
     * @return BaseResponse
     * @throws Exception\ValidationException
     * @throws Exception\HydrationException
     */
    public function send(AbstractRequest $request, ?bool $debug = false)
    {
        $request->validate($this->measurementId ? 'web' : 'firebase');
        $response = $this->getHttpClient()->post($this->getEndpoint($debug), $request->export(), $this->getOptions());

        return !$debug
            ? new BaseResponse($response)
            : new DebugResponse($response);
    }
    
    /**
     * @param AbstractRequest $request
     * @return BaseResponse
     * @throws Exception\ValidationException
     * @throws Exception\HydrationException
     */
    public function sendDebug(AbstractRequest $request)
    {
        return $this->send($request, true);
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
        $prependedWww = $this->isUseWww() ? (self::PREPENDED_WWW . '.') : '';
        return $protocolScheme . $prependedWww . $collectEndpoint . "?" . http_build_query($this->getQueryParameters());
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
     * @return bool
     */
    public function isUseWww(): bool
    {
        return $this->useWww;
    }

    /**
     * @param bool $useWww
     */
    public function setUseWww(bool $useWww)
    {
        $this->useWww = $useWww;
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
     * Returns query parameters
     * @return array
     * @throws MisconfigurationException
     */
    public function getQueryParameters(): array
    {
        $parameters = [
            'api_secret' => $this->getApiSecret(),
            'measurement_id' => $this->getMeasurementId(),
            'firebase_app_id' => $this->getFirebaseId(),
        ];
        
        if ($parameters['firebase_app_id'] && $parameters['measurement_id']) {
            throw new MisconfigurationException("Cannot specify both 'measurement_id' and 'firebase_app_id'.");
        }

        $ip = $this->getIpOverride();
        if (!empty($ip)) {
            $parameters['uip'] = $ip;

            // TODO Remove the following line when the GA4 API will support the IP override
            // https://github.com/dataunlocker/save-analytics-from-content-blockers/issues/25#issuecomment-864392422
            $parameters['_uip'] = $ip;
        }

        return array_filter($parameters);
    }

    /**
     * @return string
     */
    public function getMeasurementId(): ?string
    {
        return $this->measurementId;
    }

    /**
     * @param string $measurementId
     * @return self
     */
    public function setMeasurementId(string $measurementId): self
    {
        $this->measurementId = $measurementId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirebaseId(): ?string
    {
        return $this->firebaseId;
    }

    /**
     * @param string $firebaseId
     * @return self
     */
    public function setFirebaseId(string $firebaseId): self
    {
        $this->firebaseId = $firebaseId;
        return $this;
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
     * @return string
     */
    public function getIpOverride(): ?string
    {
        return $this->ipOverride;
    }

    /**
     * @param string $ipOverride
     */
    public function setIpOverride(string $ipOverride)
    {
        $this->ipOverride = $ipOverride;
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
    
}
