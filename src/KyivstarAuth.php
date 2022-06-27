<?php

namespace igormakarov\KyivstarSms;

use GuzzleHttp\Client;

class KyivstarAuth
{
    private string $url = 'https://api-gateway.kyivstar.ua/idp/oauth2/token';

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getToken(string $clientId, string $secret): array
    {
        $client = new Client();
        $response = $client->request('POST', $this->url, [
                'headers' =>
                    [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/x-www-form-urlencoded',
                    ],
                'body' => 'grant_type=client_credentials',
                'auth' => [$clientId, $secret, 'basic']
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }
}