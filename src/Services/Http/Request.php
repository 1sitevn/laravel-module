<?php


namespace OneSite\Module\Services\Http;


/**
 * Class Request
 * @package OneSite\Module\Services\Http
 */
class Request
{
    /**
     * @var string The HTTP method for this request.
     */
    protected $method;

    /**
     * @var string The Url for this request.
     */
    protected $url;

    /**
     * @var array The headers to send with this request.
     */
    protected $headers = [];

    /**
     * @var array The parameters to send with this request.
     */
    protected $params = [];


    /**
     * Request constructor.
     * @param string $url
     * @param string $method
     * @param array $params
     * @param array $headers
     */
    public function __construct(string $url = '', string $method = '', array $params = [], array $headers = [])
    {
        $this->url = $url;
        $this->method = $method;
        $this->headers = $headers;
        $this->params = $params;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

}
