<?php
/**
 * Created by PhpStorm.
 * User: tungnt
 * Date: 12/13/19
 * Time: 11:58
 */

namespace OneSite\Module\Services\Http;


use Illuminate\Support\Facades\Log;


/**
 * Class Response
 * @package OneSite\Module\Services\Http
 */
class Response
{

    /**
     * @var
     */
    protected $request;
    /**
     * @var
     */
    protected $response;

    /**
     * HttpResponse constructor.
     * @param $request
     * @param $response
     */
    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return \GuzzleHttp\Psr7\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        Log::channel('test')->info('Request Provider', [
            'url' => $this->getRequest()->getUrl(),
            'method' => $this->getRequest()->getMethod(),
            'headers' => $this->getRequest()->getHeaders(),
            'params' => $this->getRequest()->getParams(),
            'http_status' => $this->getResponse()->getStatusCode(),
            'response' => $this->getResponse()->getBody()->getContents()
        ]);

        return $this->getResponse()->getBody()->getContents();
    }

    /**
     * @param $message
     * @param array $errors
     * @return array
     */
    public function responseError($message, $errors = [])
    {
        return [
            'error' => [
                'message' => $message,
                'errors' => $errors
            ]
        ];
    }

    /**
     * @param $data
     * @return array
     */
    public function responseSuccess($data)
    {
        return [
            'data' => $data
        ];
    }
}
