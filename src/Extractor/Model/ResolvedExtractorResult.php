<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Extractor\Model;

class ResolvedExtractorResult
{
    /**
     * @var array<string, mixed>
     */
    private array $data;

    /**
     * @var array<string, mixed>
     */
    private array $errors;

    /**
     * @param array<string, mixed> $data
     * @param array<string, mixed> $errors
     */
    public function __construct(
        array $data,
        array $errors
    ) {
        $this->data = $data;
        $this->errors = $errors;
    }

    /**
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return array<string, mixed>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
