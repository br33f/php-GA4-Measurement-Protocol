<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 22.06.2021
 * Time: 11:10
 */

namespace Br33f\Ga4\MeasurementProtocol\Dto\Response;

use Psr\Http\Message\ResponseInterface;

class BaseResponse extends AbstractResponse
{
    /**
     * @var int|null
     */
    protected $statusCode;

    /**
     * @var string
     */
    protected $body;

    /**
     * @return int|null
     */
    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    /**
     * @param int|null $statusCode
     * @return BaseResponse
     */
    public function setStatusCode(?int $statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * Get parsed body
     * @return array
     */
    public function getData()
    {
        return json_decode($this->getBody(), true);
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return BaseResponse
     */
    public function setBody(string $body)
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
        $this->setBody($blueprint->getBody()->getContents());
    }
}