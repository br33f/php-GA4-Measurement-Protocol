<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 22.06.2021
 * Time: 10:35
 */

namespace Br33f\Ga4\MeasurementProtocol;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class HttpClient
{
    const DEFAULT_REQUEST_TIMEOUT = 30;

    /**
     * Guzzle Client
     * @var Client
     */
    protected $client;

    /**
     * Sends request to Google Analytics.
     *
     * @param string $url
     * @param array $data
     * @param array|null $options
     * @return ResponseInterface
     */
    public function post(string $url, array $data, ?array $options = [])
    {
        try {
            return $this->getClient()->post($url, $this->getPreparedOptions($options, $data));
        } catch (BadResponseException $e) {
            return $e->getResponse();
        }
    }

    /**
     * Returns guzzle client if set or creates a new instance and returns it
     * @return Client
     */
    public function getClient(): Client
    {
        if ($this->client === null) {
            $this->client = new Client();
        }

        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param $options
     * @param $data
     * @return array
     */
    protected function getPreparedOptions($options, $data)
    {
        $options[RequestOptions::JSON] = $data;

        if (!isset($options['timeout'])) {
            $options['timeout'] = self::DEFAULT_REQUEST_TIMEOUT;
        }

        if (!isset($options['connect_timeout'])) {
            $options['connect_timeout'] = self::DEFAULT_REQUEST_TIMEOUT;
        }

        return $options;
    }
}