<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Cleaner;

interface CleanerInterface
{
    /**
     * @param array<string, mixed> $config
     */
    public function clean(array $config, mixed $value): mixed;
}
