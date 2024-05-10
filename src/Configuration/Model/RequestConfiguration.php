<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Configuration\Model;

use ScraperDash\Actor\Configuration\Model\Enum\RequestProfileEnum;

class RequestConfiguration
{
    private RequestProfileEnum $profile;

    public function __construct(
        RequestProfileEnum $profile = RequestProfileEnum::NONE
    ) {
        $this->profile = $profile;
    }

    public function getProfile(): RequestProfileEnum
    {
        return $this->profile;
    }
}
