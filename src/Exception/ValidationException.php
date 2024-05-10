<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Exception;

class ValidationException extends \InvalidArgumentException
{
    /**
     * @var array<string, mixed>
     */
    private array $errors;

    /**
     * @var array<string, mixed>
     */
    private array $extractedData;

    /**
     * @param array<string, mixed> $errors
     * @param array<string, mixed> $extractedData
     */
    public function __construct(
        array $errors,
        array $extractedData,
        string $message = '',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->errors = $errors;
        $this->extractedData = $extractedData;
    }

    /**
     * @return array<string, mixed>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return array<string, mixed>
     */
    public function getExtractedData(): array
    {
        return $this->extractedData;
    }
}
