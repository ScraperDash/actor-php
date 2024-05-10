<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Configuration\Model;

use ScraperDash\Actor\Configuration\Model\Enum\ExtractionTypeEnum;
use ScraperDash\Actor\Configuration\Model\ExtractionConfig\HtmlCollectionExtractionConfiguration;

class HtmlCollectionExtraction extends AbstractExtraction
{
    private HtmlCollectionExtractionConfiguration $config;

    public function __construct(
        string $name,
        ExtractionTypeEnum $type,
        HtmlCollectionExtractionConfiguration $config,
        array $cleaners = [],
        array $validators = []
    ) {
        parent::__construct($name, $type, $cleaners, $validators);

        $this->config = $config;
    }

    public function getConfig(): HtmlCollectionExtractionConfiguration
    {
        return $this->config;
    }
}
