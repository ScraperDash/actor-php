<?php

declare(strict_types=1);

use ScraperDash\Actor\Cleaner\CleanerRepository;
use ScraperDash\Actor\Configuration\Model\Enum\ExtractionTypeEnum;
use ScraperDash\Actor\Configuration\Model\ExtractionConfig\Enum\ExtractionFocusEnum;
use ScraperDash\Actor\Configuration\Model\ExtractionConfig\HtmlCollectionExtractionConfiguration;
use ScraperDash\Actor\Configuration\Model\ExtractionConfig\HtmlExtractionConfiguration;
use ScraperDash\Actor\Configuration\Model\HtmlExtraction;
use ScraperDash\Actor\Extractor\ExtractorRepository;
use ScraperDash\Actor\Extractor\ExtractorResultResolver;
use ScraperDash\Actor\Extractor\Html\CollectionCssSelector;
use ScraperDash\Actor\Extractor\Model\ExtractorResult;
use ScraperDash\Actor\Validator\ValidatorRepository;

describe(CollectionCssSelector::class, function () {
    $pestLanding = getSample('pest.html');
    $extraction = new CollectionCssSelector();
    $extraction->setResultResolver(
        new ExtractorResultResolver(new CleanerRepository(), new ExtractorRepository(), new ValidatorRepository())
    );

    it('Extracts the collection when the selector matches content in the page', function () use (
        $pestLanding,
        $extraction,
    ) {
        $dom = new DOMDocument();
        $dom->loadHTML($pestLanding, LIBXML_NOWARNING | LIBXML_NOERROR);

        $result = $extraction->extract(new HtmlCollectionExtractionConfiguration(
            '#app section:nth-child(3) blockquote',
            [
                new HtmlExtraction(
                    'comment',
                    ExtractionTypeEnum::HTML_CSS_SELECTOR,
                    new HtmlExtractionConfiguration('p', ExtractionFocusEnum::TEXT_CONTENTS, null)
                ),
                new HtmlExtraction(
                    'author',
                    ExtractionTypeEnum::HTML_CSS_SELECTOR,
                    new HtmlExtractionConfiguration('footer', ExtractionFocusEnum::TEXT_CONTENTS, null)
                ),
            ]
        ), $dom);

        expect($result)->toBeInstanceOf(ExtractorResult::class);
        expect($result->getData())->toBeArray()->toHaveCount(4)

            ->and($result->getData()[0])->toBeArray()
            ->and($result->getData()[0]['comment'])->toContain(
                '“Pest is minimal, distraction-free, and a joy to use.”'
            )
            ->and($result->getData()[0]['author'])->toContain('Taylor Otwell  · Creator of Laravel')

            ->and($result->getData()[1])->toBeArray()
            ->and($result->getData()[1]['comment'])->toContain(
                '“It took me a year to finally give Pest a try… and ten minutes to make the switch. Pest is the way.”'
            )
            ->and($result->getData()[1]['author'])->toContain('Jeffrey Way · Laracasts Owner')

            ->and($result->getData()[2])->toBeArray()
            ->and($result->getData()[2]['comment'])->toContain(
                '“I wouldn\'t be surprised if Pest becomes the default test runner in PHP in the near future.”'
            )
            ->and($result->getData()[2]['author'])->toContain('Freek Van der Herten · Developer at Spatie')

            ->and($result->getData()[3])->toBeArray()
            ->and($result->getData()[3]['comment'])->toContain(
                '“Testing becomes an addiction in every project.”'
            )
            ->and($result->getData()[3]['author'])->toContain('Caneco · Full-Stack Developer at Medicare');
    });

    it('Extracts an empty array when the selector does not match content in the page', function () use (
        $pestLanding,
        $extraction,
    ) {
        $dom = new DOMDocument();
        $dom->loadHTML($pestLanding, LIBXML_NOWARNING | LIBXML_NOERROR);

        $result = $extraction->extract(new HtmlCollectionExtractionConfiguration(
            '#app .product',
            [
                new HtmlExtraction(
                    'price',
                    ExtractionTypeEnum::HTML_CSS_SELECTOR,
                    new HtmlExtractionConfiguration('.price', ExtractionFocusEnum::TEXT_CONTENTS, null)
                ),
            ]
        ), $dom);

        expect($result)->toBeInstanceOf(ExtractorResult::class);
        expect($result->getData())->toBeArray()->toHaveCount(0);
    });
});
