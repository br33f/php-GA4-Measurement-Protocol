<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 22.06.2021
 * Time: 11:10
 */

namespace Br33f\Ga4\MeasurementProtocol\Dto\Response;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class StreamResponse extends AbstractResponse
{
    /**
     * @var int|null
     */
    protected $statusCode;

    /**
     * @var StreamInterface
     */
    protected $body;

    /**
     * Get parsed body
     * @return array
     */
    public function getData()
    {
        return json_decode($this->getBody(), true);
    }

    /**
     * @return StreamInterface
     */
    public function getBody(): StreamInterface
    {
        return $this->body;
    }

    /**
     * @param StreamInterface $body
     * @return StreamResponse
     */
    public function setBody(StreamInterface $body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @param array|ResponseInterface $blueprint
     */
    public function hydrate($blueprint)
    {
        $this->setStatusCode($blueprint->getStatusCode());
        $this->setBody($blueprint->getBody());
    }

    /**
     * @return int|null
     */
    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    /**
     * @param int|null $statusCode
     * @return StreamResponse
     */
    public function setStatusCode(?int $statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }
}
