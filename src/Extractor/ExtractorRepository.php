<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Extractor;

use ScraperDash\Actor\Common\LazyServiceRepository;
use ScraperDash\Actor\Configuration\Model\Enum\ExtractionTypeEnum;
use ScraperDash\Actor\Extractor\Html\CollectionCssSelector;
use ScraperDash\Actor\Extractor\Html\CssSelector;
use ScraperDash\Actor\Extractor\Html\ExtractorInterface;

/**
 * @extends LazyServiceRepository<ExtractorInterface>
 */
class ExtractorRepository extends LazyServiceRepository
{
    public function __construct()
    {
        $this->add(ExtractionTypeEnum::HTML_CSS_SELECTOR->value, CssSelector::class);
        $this->add(ExtractionTypeEnum::HTML_COLLECTION_CSS_SELECTOR->value, CollectionCssSelector::class);
    }

    public function getExtractor(ExtractionTypeEnum $type): ExtractorInterface
    {
        return $this->get($type->value);
    }
}
