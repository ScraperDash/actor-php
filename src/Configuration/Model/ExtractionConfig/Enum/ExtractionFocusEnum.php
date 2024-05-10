<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Configuration\Model\ExtractionConfig\Enum;

enum ExtractionFocusEnum: string
{
    case TEXT_CONTENTS = 'text_contents';
    case ATTRIBUTE_VALUE = 'attribute_value';
}
