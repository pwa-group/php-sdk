<?php

namespace PWAGroup\PWAs;

use PWAGroup\Dictionary;

class PWA
{
    const STATUS_BLOCK = -1;
    const STATUS_CHECK_DOMAIN = 0;
    const STATUS_CHECK_HTTPS = 1;
    const STATUS_NOT_PAID = 2;
    const STATUS_STOP = 3;
    const STATUS_RUN = 4;

    private string $alias;
    private string $name;
    private int $status;
    private array $tags;
    private Tracker|null $tracker = null;
    private int $images;
    private int $vertical;
    private array $gallery;

    public function __construct(object $datum)
    {
        $this->alias = (string)$datum?->alias;
        $this->name = (string)$datum?->name;
        $this->images = (int)$datum?->images;
        $this->status = (int)$datum?->status;
        $this->vertical = (int)$datum?->vertical;
        $this->tags = (array)$datum?->tags;
        $this->gallery = (array)$datum?->gallery;
        if ($datum?->tracker) {
            $this->tracker = new Tracker($datum->tracker);
        }
    }

    public function getAlias(): string
    {
        return $this->alias ?: $this->name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function getTracker(): Tracker|null
    {
        return $this->tracker;
    }

    public function getLogo(): string
    {
        if ($this->images === -1) {
            return Dictionary::API_BASE_URI . '/' . $this->gallery[0];
        } else {
            return Dictionary::API_BASE_URI . '/verticals/' . $this->vertical . '/' . ($this->images + 1) . '/' . ($this->images + 1) . '.jpg';
        }
    }
}
