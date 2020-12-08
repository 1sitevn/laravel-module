<?php

namespace OneSite\Module\Services\Http;

use Illuminate\Support\Facades\App;


/**
 * Class Client
 * @package OneSite\Module\Services\Http
 */
abstract class Client
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    /**
     * @return mixed
     */
    abstract public function getResponse();

    /**
     * @return \GuzzleHttp\Client
     */
    public function getClient(): \GuzzleHttp\Client
    {
        return $this->client;
    }

    /**
     * @param $url
     * @param array $params
     * @param array $headers
     * @param array $options
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($url, array $params = [], array $headers = [], array $options = [])
    {
        $response = $this->getClient()->request('GET', $url, [
            'http_errors' => false,
            'verify' => false,
            'headers' => $headers,
            'query' => $params
        ]);

        return App::make($this->getResponse(), [
            'request' => new Request($url, 'GET', $params, $headers),
            'response' => $response
        ]);
    }

    /**
     * @param $url
     * @param array $params
     * @param array $headers
     * @param array $options
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post($url, array $params = [], array $headers = [], array $options = [])
    {
        $requestParams = [
            'http_errors' => false,
            'verify' => false,
            'headers' => $headers
        ];

        $isRawParams = !empty($options['is_raw']) && $options['is_raw'] ? true : false;
        if ($isRawParams) {
            $requestParams['body'] = json_encode($params);
        } else {
            $requestParams['form_params'] = $params;
        }

        $response = $this->getClient()->request('POST', $url, $requestParams);

        return App::make($this->getResponse(), [
            'request' => new Request($url, 'POST', $params, $headers),
            'response' => $response
        ]);
    }
}
