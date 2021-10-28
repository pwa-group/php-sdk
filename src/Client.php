<?php

namespace PWAGroup;

abstract class Client
{
    private \GuzzleHttp\Client|null $client = null;

    public function __construct()
    {
        $this->setClient(new \GuzzleHttp\Client(['base_uri' => Dictionary::API_BASE_URI, 'timeout' => 5.0]));
    }

    public function getClient(): \GuzzleHttp\Client
    {
        return $this->client;
    }

    public function setClient(\GuzzleHttp\Client|null $client)
    {
        $this->client = $client;
    }
}
