<?php

namespace PWAGroup;

use GuzzleHttp\Client;

abstract class Connector
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => Dictionary::API_BASE_URI, 'timeout' => 5.0]);
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
