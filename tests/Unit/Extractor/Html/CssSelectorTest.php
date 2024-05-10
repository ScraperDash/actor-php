<?php

declare(strict_types=1);

use ScraperDash\Actor\Configuration\Model\ExtractionConfig\Enum\ExtractionFocusEnum;
use ScraperDash\Actor\Configuration\Model\ExtractionConfig\HtmlExtractionConfiguration;
use ScraperDash\Actor\Extractor\Html\CssSelector;
use ScraperDash\Actor\Extractor\Model\ExtractorResult;

describe(CssSelector::class, function () {
    $pestLanding = getSample('pest.html');
    $extraction = new CssSelector();

    describe(ExtractionFocusEnum::TEXT_CONTENTS->value, function () use ($pestLanding, $extraction) {
        it('Extracts the text content when a selector matches content in the page', function () use (
            $pestLanding,
            $extraction
        ) {
            $dom = new DOMDocument();
            $dom->loadHTML($pestLanding, LIBXML_NOWARNING | LIBXML_NOERROR);

            $result = $extraction->extract(new HtmlExtractionConfiguration(
                'a[href="/docs/installation"]',
                ExtractionFocusEnum::TEXT_CONTENTS
            ), $dom);

            expect($result)->toBeInstanceOf(ExtractorResult::class);
            expect($result->getData())->toBeString()->toContain('Get started');
        });

        it('Extracts null when a selector does not match any content', function () use ($pestLanding, $extraction) {
            $dom = new DOMDocument();
            $dom->loadHTML($pestLanding, LIBXML_NOWARNING | LIBXML_NOERROR);

            $result = $extraction->extract(new HtmlExtractionConfiguration(
                'product',
                ExtractionFocusEnum::TEXT_CONTENTS
            ), $dom);

            expect($result)->toBeInstanceOf(ExtractorResult::class);
            expect($result->getData())->toBeNull();
        });
    });

    describe(ExtractionFocusEnum::ATTRIBUTE_VALUE->value, function () use ($pestLanding, $extraction) {
        it('Extracts the attribute content when a selector matches content in the page', function () use (
            $pestLanding,
            $extraction
        ) {
            $dom = new DOMDocument();
            $dom->loadHTML($pestLanding, LIBXML_NOWARNING | LIBXML_NOERROR);

            $result = $extraction->extract(new HtmlExtractionConfiguration(
                'a[href="/docs/installation"]',
                ExtractionFocusEnum::ATTRIBUTE_VALUE,
                'href'
            ), $dom);

            expect($result)->toBeInstanceOf(ExtractorResult::class);
            expect($result->getData())->toBeString()->toContain('/docs/installation');
        });

        it('Extracts null when a selector does not match any content', function () use ($pestLanding, $extraction) {
            $dom = new DOMDocument();
            $dom->loadHTML($pestLanding, LIBXML_NOWARNING | LIBXML_NOERROR);

            $result = $extraction->extract(new HtmlExtractionConfiguration(
                '#product',
                ExtractionFocusEnum::ATTRIBUTE_VALUE,
                'class'
            ), $dom);

            expect($result)->toBeInstanceOf(ExtractorResult::class);
            expect($result->getData())->toBeNull();
        });
    });
});
