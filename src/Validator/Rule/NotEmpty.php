<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Validator\Rule;

use Respect\Validation\Validator;
use ScraperDash\Actor\Validator\RuleInterface;

class NotEmpty implements RuleInterface
{
    public function validate(array $config, mixed $value): bool
    {
        return Validator::notEmpty()->validate($value);
    }

    public function getMessage(array $config): string
    {
        return 'This value must not be empty.';
    }
}
