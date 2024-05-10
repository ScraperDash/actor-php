<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Configuration\Model\ExtractionConfig;

use ScraperDash\Actor\Configuration\Model\ExtractionConfig\Enum\ExtractionFocusEnum;

class HtmlExtractionConfiguration implements ExtractionConfigurationInterface
{
    private string $selector;
    private ExtractionFocusEnum $focus;
    private string|null $attribute;

    public function __construct(
        string $selector,
        ExtractionFocusEnum $focus = ExtractionFocusEnum::TEXT_CONTENTS,
        string|null $attribute = null
    ) {
        $this->selector = $selector;
        $this->focus = $focus;
        $this->attribute = $attribute;
    }

    public function getSelector(): string
    {
        return $this->selector;
    }

    public function getFocus(): ExtractionFocusEnum
    {
        return $this->focus;
    }

    public function getAttribute(): ?string
    {
        return $this->attribute;
    }
}
