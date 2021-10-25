<?php

namespace PWAGroup\PWAs;

use GuzzleHttp\Client;
use PWAGroup\Auth;
use PWAGroup\Dictionary;

class Pages
{
    private Client $client;
    private array $filters = [];
    private int $count = 0;
    private int $pageIndex = 1;

    public function __construct(public Auth $auth, public int $pageSize = 20)
    {
        $this->client = new Client(['base_uri' => Dictionary::API_BASE_URI, 'timeout' => 5.0]);
    }

    /**
     * @return PWA[]
     */
    public function getPage(int $pageIndex = 1): array
    {
        $this->pageIndex = $pageIndex;
        return $this->asyncData();
    }

    /**
     * @return PWA[]
     */
    public function nextPage(): array
    {
        if ($this->getCountPages() > $this->pageIndex) {
            $this->pageIndex++;
        }
        return $this->asyncData();
    }

    /**
     * @return PWA[]
     */
    public function prevPage(): array
    {
        if ($this->pageIndex > 1) {
            $this->pageIndex--;
        }
        return $this->asyncData();
    }

    public function setFilter(string $filter, $value): void
    {
        $this->filters[$filter] = $value;
    }

    public function unsetFilter(string $filter): void
    {
        unset($this->filters[$filter]);
    }

    protected function getCountPages(): int
    {
        return ceil($this->count / $this->pageSize);
    }

    protected function asyncData(): array
    {
        $query = array_merge($this->filters, [
            'pageSize' => $this->pageSize,
            'pageIndex' => $this->pageIndex
        ]);
        $response = $this->client->request('GET', Dictionary::API_ENDPOINT_PWAS, [
            'query' => $query,
            'headers' => $this->auth->getAuthHeader()
        ]);
        $body = (string)$response->getBody();
        $body = json_decode($body, false);
        $this->count = $body?->itemsCount;
        $PWAs = [];
        foreach ($body?->data as $datum) {
            $PWAs[] = new PWA($datum);
        }
        return $PWAs;
    }
}
