<?php

declare(strict_types=1);

use ScraperDash\Actor\Configuration\Model\Enum\ExtractionTypeEnum;
use ScraperDash\Actor\Extractor\ExtractorRepository;
use ScraperDash\Actor\Extractor\Html\CssSelector;

describe(ExtractorRepository::class, function () {
    $repository = new ExtractorRepository();

    it('Returns the appropriate Extractor based on the provided configuration', function () use ($repository) {
        expect($repository->getExtractor(ExtractionTypeEnum::HTML_CSS_SELECTOR))
            ->toBeInstanceOf(CssSelector::class);
    });
});
