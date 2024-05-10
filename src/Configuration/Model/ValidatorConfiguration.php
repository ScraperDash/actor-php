<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Configuration\Model;

use ScraperDash\Actor\Configuration\Model\Enum\ExtractionValidatorTypeEnum;

class ValidatorConfiguration
{
    private ExtractionValidatorTypeEnum $type;

    /**
     * @var array<string, mixed>
     */
    private array $config;

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(
        ExtractionValidatorTypeEnum $type,
        array $config = []
    ) {
        $this->type = $type;
        $this->config = $config;
    }

    public function getType(): ExtractionValidatorTypeEnum
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
