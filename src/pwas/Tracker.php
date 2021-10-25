<?php

namespace PWAGroup\PWAs;

class Tracker
{
    private array $locales = [];

    public function __construct(object $datum)
    {
        foreach ($datum?->filters as $filter) {
            $this->locales[] = (string)$filter->_id;
        }
    }

    public function getLocales(): array
    {
        return $this->locales;
    }
}
