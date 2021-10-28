<?php

namespace PWAGroup;

class Auth extends Connector
{
    private string $accessToken = '';

    public function __construct(public string $apiKey = '')
    {
        parent::__construct();
        $response = $this->getClient()->request('POST', Dictionary::API_ENDPOINT_AUTH, ['form_params' => ['key' => $apiKey]]);
        $body = (string)$response->getBody();
        $body = json_decode($body, true);
        $this->accessToken = (string)$body['accessToken'];
    }

    public function getAuthHeader(): array
    {
        return ['Authorization' => 'Bearer ' . $this->accessToken];
    }
}
