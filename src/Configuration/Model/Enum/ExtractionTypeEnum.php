<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Configuration\Model\Enum;

enum ExtractionTypeEnum: string
{
    case HTML_CSS_SELECTOR = 'html_css_selector';
    case HTML_COLLECTION_CSS_SELECTOR = 'html_collection_css_selector';
}
