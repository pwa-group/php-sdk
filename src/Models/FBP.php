<?php

namespace PWAGroup\Models;

class FBP
{
    private int $id;
    private string $lead;

    public function __construct(array $datum)
    {
        $this->id = (int)($datum['_id'] ?? $datum['id']);
        if (in_array($datum['lead'], ['install', 'registration'])) {
            $this->lead = $datum['lead'];
        } else {
            throw new \TypeError('FBP lead must contain install or registration');
        }
    }

    public function getID(): int
    {
        return $this->id;
    }

    public function getLead(): string
    {
        return $this->lead;
    }
}
