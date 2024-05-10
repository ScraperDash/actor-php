<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Validator;

interface RuleInterface
{
    /**
     * @param array<string, mixed> $config
     */
    public function validate(array $config, mixed $value): bool;

    /**
     * @param array<string, mixed> $config
     */
    public function getMessage(array $config): string;
}
