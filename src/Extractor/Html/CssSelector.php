<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Extractor\Html;

use Assert\Assertion;
use ScraperDash\Actor\Configuration\Model\ExtractionConfig\Enum\ExtractionFocusEnum;
use ScraperDash\Actor\Configuration\Model\ExtractionConfig\ExtractionConfigurationInterface;
use ScraperDash\Actor\Configuration\Model\ExtractionConfig\HtmlExtractionConfiguration;
use ScraperDash\Actor\Extractor\Model\ExtractorResult;
use Symfony\Component\CssSelector\CssSelectorConverter;
use function Psl\Iter\first;

class CssSelector implements ExtractorInterface
{
    private CssSelectorConverter $cssSelectorConverter;

    public function __construct()
    {
        $this->cssSelectorConverter = new CssSelectorConverter();
    }

    public function extract(ExtractionConfigurationInterface $config, \DOMDocument $dom): ExtractorResult
    {
        Assertion::isInstanceOf($config, HtmlExtractionConfiguration::class);

        $selector = $config->getSelector();
        $xPath = $this->cssSelectorConverter->toXPath($selector);

        $domXPath = new \DOMXPath($dom);

        $nodes = $domXPath->query($xPath);
        Assertion::isTraversable($nodes);

        $firstNode = first($nodes);
        if ($config->getFocus() === ExtractionFocusEnum::ATTRIBUTE_VALUE) {
            Assertion::notNull($config->getAttribute());

            return new ExtractorResult(
                $firstNode?->attributes?->getNamedItem($config->getAttribute())?->textContent,
                []
            );
        }

        return new ExtractorResult($firstNode?->nodeValue, []);
    }
}
