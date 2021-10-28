<?php

namespace PWAGroup\PWAs;

use PWAGroup\Auth;
use PWAGroup\Client;
use PWAGroup\Dictionary;

class PWA extends Client
{
    public function __construct(public Auth $auth)
    {
        parent::__construct();
    }

    protected function getEndpoint(string $id): string
    {
        return str_replace('{id}', $id, Dictionary::API_ENDPOINT_PWA);
    }

    public function read(string $id): \PWAGroup\Models\PWA
    {
        $response = $this->getClient()->request('GET', $this->getEndpoint($id), [
            'headers' => $this->auth->getAuthHeader()
        ]);
        $body = (string)$response->getBody();
        $body = json_decode($body, true);
        return new \PWAGroup\Models\PWA($body);
    }

    public function update(\PWAGroup\Models\PWA $PWA): bool
    {
        $response = $this->getClient()->request('PUT', $this->getEndpoint($PWA->getID()), [
            'json' => $PWA->getChanges(),
            'headers' => $this->auth->getAuthHeader()
        ]);
        return $response->getStatusCode() === 204;
    }
}
