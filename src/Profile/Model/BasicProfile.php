<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Profile\Model;

use ScraperDash\Actor\Profile\ProfileInterface;

class BasicProfile implements ProfileInterface
{
    public function getHeaders(): array
    {
        return [
            'Upgrade-Insecure-Requests' => $this->getUpgradeInsecureRequests(),
            'User-Agent' => $this->getUserAgent(),
            'Accept' => $this->getAccept(),
            'Accept-Language' => $this->getAcceptLanguage(),
            'DNT' => $this->getDnt(),
        ];
    }

    private function getUserAgent(): string
    {
        return 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36';
    }

    private function getAccept(): string
    {
        return 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8';
    }

    private function getAcceptLanguage(): string
    {
        return 'en-US,en;q=0.9';
    }

    private function getDnt(): string
    {
        return '1';
    }

    private function getUpgradeInsecureRequests(): string
    {
        return '1';
    }
}
