<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Configuration\Model\ExtractionConfig;

use ScraperDash\Actor\Configuration\Model\AbstractExtraction;

class HtmlCollectionExtractionConfiguration implements ExtractionConfigurationInterface
{
    private string $selector;

    /**
     * @var AbstractExtraction[]
     */
    private array $extractions;

    /**
     * @param AbstractExtraction[] $extractions
     */
    public function __construct(
        string $selector,
        array $extractions
    ) {
        $this->selector = $selector;
        $this->extractions = $extractions;
    }

    public function getSelector(): string
    {
        return $this->selector;
    }

    /**
     * @return AbstractExtraction[]
     */
    public function getExtractions(): array
    {
        return $this->extractions;
    }
}
