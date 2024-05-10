<?php

declare(strict_types=1);

use ScraperDash\Actor\Configuration\Model\CleanerConfiguration;
use ScraperDash\Actor\Configuration\Model\Configuration;
use ScraperDash\Actor\Configuration\Model\Enum\ExtractionCleanerTypeEnum;
use ScraperDash\Actor\Configuration\Model\Enum\ExtractionTypeEnum;
use ScraperDash\Actor\Configuration\Model\Enum\ExtractionValidatorTypeEnum;
use ScraperDash\Actor\Configuration\Model\Enum\OutputTypeEnum;
use ScraperDash\Actor\Configuration\Model\Enum\RequestProfileEnum;
use ScraperDash\Actor\Configuration\Model\ExtractionConfig\Enum\ExtractionFocusEnum;
use ScraperDash\Actor\Configuration\Model\ExtractionConfig\HtmlCollectionExtractionConfiguration;
use ScraperDash\Actor\Configuration\Model\ExtractionConfig\HtmlExtractionConfiguration;
use ScraperDash\Actor\Configuration\Model\Factory\ConfigurationFactory;
use ScraperDash\Actor\Configuration\Model\HtmlCollectionExtraction;
use ScraperDash\Actor\Configuration\Model\HtmlExtraction;
use ScraperDash\Actor\Configuration\Model\OutputConfiguration;
use ScraperDash\Actor\Configuration\Model\RequestConfiguration;
use ScraperDash\Actor\Configuration\Model\ValidatorConfiguration;
use ScraperDash\Actor\Exception\InvalidConfigurationException;

describe(ConfigurationFactory::class, function () {
    $factory = new ConfigurationFactory();

    it('Accepts valid JSON and returns appropriate Configuration', function () use ($factory) {
        $sampleConfiguration = getSample('configuration.json');

        $result = $factory->create($sampleConfiguration);
        expect($result)
            ->toBeInstanceOf(Configuration::class)
            ->and($result->getVersion())->toEqual('latest')

            ->and($result->getRequest())->toBeInstanceOf(RequestConfiguration::class)
            ->and($result->getRequest()->getProfile())->toEqual(RequestProfileEnum::NONE)

            ->and($result->getOutput())->toBeInstanceOf(OutputConfiguration::class)
            ->and($result->getOutput()->getType())->toEqual(OutputTypeEnum::MAP)
            ->and($result->getOutput()->getModel())->toBeNull()
            ->and($result->getExtractions())->toBeArray()->toHaveCount(3)

            ->and($result->getExtractions()[0])->toBeInstanceOf(HtmlExtraction::class)
            ->and($result->getExtractions()[0]->getType())->toEqual(ExtractionTypeEnum::HTML_CSS_SELECTOR)
            ->and($result->getExtractions()[0]->getName())->toEqual('startedButton')
            ->and($result->getExtractions()[0]->getConfig())->toBeInstanceOf(HtmlExtractionConfiguration::class)
            ->and($result->getExtractions()[0]->getConfig()->getSelector())->toEqual('a[href="/docs/installation"]')
            ->and($result->getExtractions()[0]->getConfig()->getFocus())->toEqual(
                ExtractionFocusEnum::TEXT_CONTENTS
            )
            ->and($result->getExtractions()[0]->getConfig()->getAttribute())->toBeNull()
            ->and($result->getExtractions()[0]->getCleaners())->toBeArray()->toHaveCount(1)
            ->and($result->getExtractions()[0]->getCleaners()[0])->toBeInstanceOf(CleanerConfiguration::class)
            ->and($result->getExtractions()[0]->getCleaners()[0]->getType())->toEqual(
                ExtractionCleanerTypeEnum::STRING_TRIM
            )
            ->and($result->getExtractions()[0]->getValidators())->toBeArray()->toHaveCount(1)
            ->and($result->getExtractions()[0]->getValidators()[0])->toBeInstanceOf(ValidatorConfiguration::class)
            ->and($result->getExtractions()[0]->getValidators()[0]->getType())->toEqual(
                ExtractionValidatorTypeEnum::NOT_EMPTY
            )

            ->and($result->getExtractions()[1])->toBeInstanceOf(HtmlCollectionExtraction::class)
            ->and($result->getExtractions()[1]->getType())->toEqual(
                ExtractionTypeEnum::HTML_COLLECTION_CSS_SELECTOR
            )
            ->and($result->getExtractions()[1]->getName())->toEqual('testimonials')
            ->and($result->getExtractions()[1]->getConfig())->toBeInstanceOf(
                HtmlCollectionExtractionConfiguration::class
            )
            ->and($result->getExtractions()[1]->getConfig()->getSelector())->toEqual(
                '#app section:nth-child(3) blockquote'
            )
            ->and($result->getExtractions()[1]->getConfig()->getExtractions())->toBeArray()->toHaveCount(3)
            ->and($result->getExtractions()[1]->getConfig()->getExtractions()[0])->toBeInstanceOf(
                HtmlExtraction::class
            )
            ->and($result->getExtractions()[1]->getConfig()->getExtractions()[0]->getType())->toEqual(
                ExtractionTypeEnum::HTML_CSS_SELECTOR
            )
            ->and($result->getExtractions()[1]->getConfig()->getExtractions()[0]->getName())->toEqual('comment')
            ->and(
                $result->getExtractions()[1]->getConfig()->getExtractions()[0]->getConfig()
            )->toBeInstanceOf(HtmlExtractionConfiguration::class)
            ->and(
                $result->getExtractions()[1]->getConfig()->getExtractions()[0]->getConfig()->getSelector()
            )->toEqual('p')
            ->and(
                $result->getExtractions()[1]->getConfig()->getExtractions()[0]->getConfig()->getFocus()
            )->toEqual(ExtractionFocusEnum::TEXT_CONTENTS)
            ->and(
                $result->getExtractions()[1]->getConfig()->getExtractions()[0]->getConfig()->getAttribute()
            )->toBeNull()
            ->and(
                $result->getExtractions()[1]->getConfig()->getExtractions()[0]->getCleaners()
            )->toBeArray()->toHaveCount(1)
            ->and(
                $result->getExtractions()[1]->getConfig()->getExtractions()[0]->getCleaners()[0]
            )->toBeInstanceOf(CleanerConfiguration::class)
            ->and(
                $result->getExtractions()[1]->getConfig()->getExtractions()[0]->getCleaners()[0]->getType()
            )->toEqual(ExtractionCleanerTypeEnum::STRING_TRIM)
            ->and(
                $result->getExtractions()[1]->getConfig()->getExtractions()[0]->getValidators()
            )->toBeArray()->toHaveCount(0)
            ->and($result->getExtractions()[1]->getConfig()->getExtractions()[1])->toBeInstanceOf(
                HtmlExtraction::class
            )
            ->and($result->getExtractions()[1]->getConfig()->getExtractions()[1]->getType())->toEqual(
                ExtractionTypeEnum::HTML_CSS_SELECTOR
            )
            ->and($result->getExtractions()[1]->getConfig()->getExtractions()[1]->getName())->toEqual('author')
            ->and(
                $result->getExtractions()[1]->getConfig()->getExtractions()[1]->getConfig()
            )->toBeInstanceOf(HtmlExtractionConfiguration::class)
            ->and(
                $result->getExtractions()[1]->getConfig()->getExtractions()[1]->getConfig()->getSelector()
            )->toEqual('footer')
            ->and(
                $result->getExtractions()[1]->getConfig()->getExtractions()[1]->getConfig()->getFocus()
            )->toEqual(ExtractionFocusEnum::TEXT_CONTENTS)
            ->and(
                $result->getExtractions()[1]->getConfig()->getExtractions()[1]->getConfig()->getAttribute()
            )->toBeNull()
            ->and(
                $result->getExtractions()[1]->getConfig()->getExtractions()[1]->getCleaners()
            )->toBeArray()->toHaveCount(0)
            ->and(
                $result->getExtractions()[1]->getConfig()->getExtractions()[1]->getValidators()
            )->toBeArray()->toHaveCount(1)
            ->and(
                $result->getExtractions()[1]->getConfig()->getExtractions()[1]->getValidators()[0]
            )->toBeInstanceOf(ValidatorConfiguration::class)
            ->and(
                $result->getExtractions()[1]->getConfig()->getExtractions()[1]->getValidators()[0]->getType()
            )->toEqual(ExtractionValidatorTypeEnum::NOT_EMPTY)
            ->and($result->getExtractions()[1]->getConfig()->getExtractions()[2])->toBeInstanceOf(
                HtmlExtraction::class
            )
            ->and($result->getExtractions()[1]->getConfig()->getExtractions()[2]->getType())->toEqual(
                ExtractionTypeEnum::HTML_CSS_SELECTOR
            )
            ->and($result->getExtractions()[1]->getConfig()->getExtractions()[2]->getName())->toEqual('link')
            ->and(
                $result->getExtractions()[1]->getConfig()->getExtractions()[2]->getConfig()
            )->toBeInstanceOf(HtmlExtractionConfiguration::class)
            ->and(
                $result->getExtractions()[1]->getConfig()->getExtractions()[2]->getConfig()->getSelector()
            )->toEqual('a')
            ->and(
                $result->getExtractions()[1]->getConfig()->getExtractions()[2]->getConfig()->getFocus()
            )->toEqual(ExtractionFocusEnum::ATTRIBUTE_VALUE)
            ->and(
                $result->getExtractions()[1]->getConfig()->getExtractions()[2]->getConfig()->getAttribute()
            )->toEqual('href')
            ->and(
                $result->getExtractions()[1]->getConfig()->getExtractions()[2]->getCleaners()
            )->toBeArray()->toHaveCount(0)
            ->and(
                $result->getExtractions()[1]->getConfig()->getExtractions()[2]->getValidators()
            )->toBeArray()->toHaveCount(0)

            ->and($result->getExtractions()[2])->toBeInstanceOf(HtmlExtraction::class)
        ;
    });

    it('Throws an exception for JSON that does not match expectations', function () use ($factory) {
        $result = $factory->create('[]');
    })->throws(InvalidConfigurationException::class);
});
