<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Profile;

interface ProfileInterface
{
    /**
     * @return array<string, string>
     */
    public function getHeaders(): array;
}
