<?php

namespace PWAGroup;

use GuzzleHttp\Client;

class Auth
{
    private string $accessToken = '';

    public function __construct(public string $apiKey = '')
    {
        $client = new Client(['base_uri' => Dictionary::API_BASE_URI, 'timeout' => 2.0]);
        $response = $client->request('POST', Dictionary::API_ENDPOINT_AUTH, ['form_params' => ['key' => $apiKey]]);
        $body = (string)$response->getBody();
        $body = json_decode($body, true);
        $this->accessToken = (string)$body['accessToken'];
    }

    public function getAuthHeader(): array
    {
        return ['Authorization' => 'Bearer ' . $this->accessToken];
    }
}
