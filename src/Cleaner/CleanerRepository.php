<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Cleaner;

use ScraperDash\Actor\Cleaner\String\Trim;
use ScraperDash\Actor\Common\LazyServiceRepository;
use ScraperDash\Actor\Configuration\Model\Enum\ExtractionCleanerTypeEnum;

/**
 * @extends LazyServiceRepository<CleanerInterface>
 */
class CleanerRepository extends LazyServiceRepository
{
    public function __construct()
    {
        $this->add(ExtractionCleanerTypeEnum::STRING_TRIM->value, Trim::class);
    }

    public function getCleaner(ExtractionCleanerTypeEnum $type): CleanerInterface
    {
        return $this->get($type->value);
    }
}
