<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Extractor\Model;

class ExtractorResult
{
    private mixed $data;

    /**
     * @var array<string|int, mixed>
     */
    private array $errors;

    /**
     * @param array<string|int, mixed> $errors
     */
    public function __construct(
        mixed $data,
        array $errors
    ) {
        $this->data = $data;
        $this->errors = $errors;
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * @return array<string|int, mixed>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
