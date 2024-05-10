<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Validator;

use ScraperDash\Actor\Common\LazyServiceRepository;
use ScraperDash\Actor\Configuration\Model\Enum\ExtractionValidatorTypeEnum;
use ScraperDash\Actor\Validator\Rule\NotEmpty;

/**
 * @extends LazyServiceRepository<RuleInterface>
 */
class ValidatorRepository extends LazyServiceRepository
{
    public function __construct()
    {
        $this->add(ExtractionValidatorTypeEnum::NOT_EMPTY->value, NotEmpty::class);
    }

    public function getValidator(ExtractionValidatorTypeEnum $type): RuleInterface
    {
        return $this->get($type->value);
    }
}
