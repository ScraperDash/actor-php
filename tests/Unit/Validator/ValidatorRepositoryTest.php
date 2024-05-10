<?php

declare(strict_types=1);

use ScraperDash\Actor\Configuration\Model\Enum\ExtractionValidatorTypeEnum;
use ScraperDash\Actor\Validator\Rule\NotEmpty;
use ScraperDash\Actor\Validator\ValidatorRepository;

describe(ValidatorRepository::class, function () {
    $repository = new ValidatorRepository();

    it('Returns the appropriate Rule based on the provided configuration', function () use ($repository) {
        expect($repository->getValidator(ExtractionValidatorTypeEnum::NOT_EMPTY))
            ->toBeInstanceOf(NotEmpty::class);
    });
});
