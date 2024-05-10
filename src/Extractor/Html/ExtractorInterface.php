<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Extractor\Html;

use ScraperDash\Actor\Configuration\Model\ExtractionConfig\ExtractionConfigurationInterface;
use ScraperDash\Actor\Extractor\Model\ExtractorResult;

interface ExtractorInterface
{
    public function extract(ExtractionConfigurationInterface $config, \DOMDocument $dom): ExtractorResult;
}
