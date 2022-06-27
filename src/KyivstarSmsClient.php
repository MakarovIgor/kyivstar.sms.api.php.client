<?php

namespace igormakarov\KyivstarSms;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use igormakarov\KyivstarSms\Exceptions\UnauthorizedException;
use igormakarov\KyivstarSms\Routes\Route;
use igormakarov\KyivstarSms\Routes\Sms;
use Psr\Http\Message\ResponseInterface;

class KyivstarSmsClient
{
    private Client $httpClient;
    private string $apiServerUrl;
    //private string $token;
    private array $requestOptions;

    public function __construct(string $apiServerUrl, string $token)
    {
        $this->httpClient = new Client();
        $this->apiServerUrl = $apiServerUrl;

        $this->requestOptions = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ]
        ];
    }

    /**
     * @throws UnauthorizedException
     */
    public function deliveryStatusSms($messageId)
    {
        $response = $this->sendRequest(
            (new Sms($this->apiServerUrl))->deliveryStatus($messageId),
            $this->requestOptions
        );
        $this->validateResponse($response);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @throws UnauthorizedException
     */
    public function sendSms(Message $message): string
    {
        $options = $this->requestOptions;
        $options['body'] = $message;

        $response = $this->sendRequest((new Sms($this->apiServerUrl))->send(), $options);
        $this->validateResponse($response);
        return json_decode($response->getBody()->getContents(), true)['msgId'];
    }

    /**
     * @throws UnauthorizedException
     * @throws Exception
     */
    public function validateResponse(ResponseInterface $response)
    {
        $content = json_decode($response->getBody()->getContents(), true);
        var_dump("error", $content);
        switch ($response->getStatusCode()) {
            case 401: throw new UnauthorizedException($content['error']['message'], 401);
            case 422: throw new Exception($content['errorMsg'], (int)['errorCode']);
        }
        $response->getBody()->seek(0);
    }


    protected function sendRequest(Route $route, array $params = [])
    {
        try {
            return $this->httpClient->request($route->method(), $route->url(), $params);
        } catch (ClientException $ex) {
            return $ex->getResponse();
        }
    }

}