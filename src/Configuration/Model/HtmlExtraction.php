<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Configuration\Model;

use ScraperDash\Actor\Configuration\Model\Enum\ExtractionTypeEnum;
use ScraperDash\Actor\Configuration\Model\ExtractionConfig\HtmlExtractionConfiguration;

class HtmlExtraction extends AbstractExtraction
{
    private HtmlExtractionConfiguration $config;

    public function __construct(
        string $name,
        ExtractionTypeEnum $type,
        HtmlExtractionConfiguration $config,
        array $cleaners = [],
        array $validators = []
    ) {
        parent::__construct($name, $type, $cleaners, $validators);

        $this->config = $config;
    }

    public function getConfig(): HtmlExtractionConfiguration
    {
        return $this->config;
    }
}
