<?php

declare(strict_types=1);

use ScraperDash\Actor\Cleaner\CleanerRepository;
use ScraperDash\Actor\Cleaner\String\Trim;
use ScraperDash\Actor\Configuration\Model\Enum\ExtractionCleanerTypeEnum;

describe(CleanerRepository::class, function () {
    $repository = new CleanerRepository();

    it('Returns the appropriate Cleaner based on the provided configuration', function () use ($repository) {
        expect($repository->getCleaner(ExtractionCleanerTypeEnum::STRING_TRIM))
            ->toBeInstanceOf(Trim::class);
    });
});
