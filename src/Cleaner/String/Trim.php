<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Cleaner\String;

use Assert\Assertion;
use ScraperDash\Actor\Cleaner\CleanerInterface;

class Trim implements CleanerInterface
{
    public function clean(array $config, mixed $value): string|null
    {
        if ($value === null) {
            return null;
        }

        Assertion::string($value);

        return trim($value);
    }
}
