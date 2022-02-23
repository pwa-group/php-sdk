<?php

namespace PWAGroup\Models;

class Tracker
{
    private array $locales = [];

    public function __construct(array $datum)
    {
        $this->locales = $datum['filters'];
    }

    public function getLocales(): array
    {
        return $this->locales;
    }
}
