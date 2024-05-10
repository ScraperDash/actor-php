<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Configuration\Model;

class Configuration
{
    private string $version;
    private RequestConfiguration $request;

    /**
     * @var AbstractExtraction[]
     */
    private array $extractions;
    private OutputConfiguration $output;

    /**
     * @param AbstractExtraction[] $extractions
     */
    public function __construct(
        string $version,
        RequestConfiguration $request,
        array $extractions,
        OutputConfiguration $output
    ) {
        $this->version = $version;
        $this->request = $request;
        $this->extractions = $extractions;
        $this->output = $output;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getRequest(): RequestConfiguration
    {
        return $this->request;
    }

    /**
     * @return AbstractExtraction[]
     */
    public function getExtractions(): array
    {
        return $this->extractions;
    }

    public function getOutput(): OutputConfiguration
    {
        return $this->output;
    }
}
