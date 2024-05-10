<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Extractor\Html;

use Assert\Assertion;
use ScraperDash\Actor\Configuration\Model\ExtractionConfig\ExtractionConfigurationInterface;
use ScraperDash\Actor\Configuration\Model\ExtractionConfig\HtmlCollectionExtractionConfiguration;
use ScraperDash\Actor\Extractor\ExtractorResultResolver;
use ScraperDash\Actor\Extractor\Model\ExtractorResult;
use Symfony\Component\CssSelector\CssSelectorConverter;

class CollectionCssSelector implements ExtractorInterface
{
    private ExtractorResultResolver $extractorResultResolver;
    private CssSelectorConverter $cssSelectorConverter;

    public function __construct()
    {
        $this->cssSelectorConverter = new CssSelectorConverter();
    }

    public function extract(ExtractionConfigurationInterface $config, \DOMDocument $dom): ExtractorResult
    {
        Assertion::isInstanceOf($config, HtmlCollectionExtractionConfiguration::class);

        $selector = $config->getSelector();
        $xPath = $this->cssSelectorConverter->toXPath($selector);
        $domXPath = new \DOMXPath($dom);

        $nodes = $domXPath->query($xPath);
        Assertion::isTraversable($nodes);

        $data = [];
        $errors = [];
        foreach ($nodes as $nodeNumber => $node) {
            $filteredDom = new \DOMDocument();
            $filteredDom->appendChild($filteredDom->importNode($node, true));

            $result = $this->extractorResultResolver->resolve($config->getExtractions(), $filteredDom);

            $data[$nodeNumber] = $result->getData();

            if (count($result->getErrors()) > 0) {
                $errors[$nodeNumber] = $result->getErrors();
            }
        }

        return new ExtractorResult($data, $errors);
    }

    public function setResultResolver(ExtractorResultResolver $extractorResultResolver): void
    {
        $this->extractorResultResolver = $extractorResultResolver;
    }
}
