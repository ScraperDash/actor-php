<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Configuration\Model;

use ScraperDash\Actor\Configuration\Model\Enum\ExtractionCleanerTypeEnum;

class CleanerConfiguration
{
    private ExtractionCleanerTypeEnum $type;

    /**
     * @var array<string, mixed>
     */
    private array $config;

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(
        ExtractionCleanerTypeEnum $type,
        array $config = []
    ) {
        $this->type = $type;
        $this->config = $config;
    }

    public function getType(): ExtractionCleanerTypeEnum
    {
        return $this->type;
    }

    /**
     * @return array<string, mixed>
     */
    public function getConfig(): array
    {
        return $this->config;
    }
}
