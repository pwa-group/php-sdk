<?php

namespace PWAGroup\Models;

use PWAGroup\Dictionary;

class PWA
{
    const STATUS_BLOCK = -1;
    const STATUS_CHECK_DOMAIN = 0;
    const STATUS_CHECK_HTTPS = 1;
    const STATUS_NOT_PAID = 2;
    const STATUS_STOP = 3;
    const STATUS_RUN = 4;

    private string $id;
    private string $alias;
    private string $name;
    private int $status;
    private array $tags;
    private Tracker|null $tracker = null;
    private int $images;
    private int $vertical;
    private array $gallery;
    /**
     * @var FBP[]
     */
    private array $FBPs = [];

    private $changes = [];

    public function __construct(array $datum)
    {
        $this->id = (string)($datum['_id'] ?? $datum['id']);
        $this->alias = (string)$datum['alias'];
        $this->name = (string)$datum['name'];
        $this->images = (int)$datum['images'];
        $this->status = (int)$datum['status'];
        $this->vertical = (int)$datum['vertical'];
        $this->tags = (array)$datum['tags'];
        $this->gallery = (array)$datum['gallery'];
        if (isset($datum['tracker'])) {
            $this->tracker = new Tracker($datum['tracker']);
        }
        if (isset($datum['FBPs'])) {
            $FBPs = [];
            foreach ($datum['FBPs'] as $FBP) {
                $FBPs[] = new FBP($FBP);
            }
            $this->setFBPs($FBPs, false);
        }
    }

    public function getID(): string
    {
        return $this->id;
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

    public function getLocales(): array
    {
        if (is_null($this->tracker)) {
            return [];
        } else {
            return $this->tracker->getLocales();
        }
    }

    public function getFBPs(): array
    {
        return $this->FBPs;
    }

    public function setFBPs(array $FBPs, $toChange = true)
    {
        $this->FBPs = [];
        $this->FBPs = $FBPs;
        if ($toChange) {
            $this->changes['FBPs'] = $FBPs;
        }
    }

    public function getChanges(): array
    {
        $changes = $this->changes;
        $changes['FBPs'] = [];
        foreach ($this->changes['FBPs'] as $FBP) {
            $changes['FBPs'][] = [
                '_id' => $FBP->getID(),
                'lead' => $FBP->getLead(),
            ];
        }
        return $changes;
    }
}
