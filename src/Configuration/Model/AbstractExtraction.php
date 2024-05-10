<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Configuration\Model;

use ScraperDash\Actor\Configuration\Model\Enum\ExtractionTypeEnum;
use ScraperDash\Actor\Configuration\Model\ExtractionConfig\ExtractionConfigurationInterface;
use Symfony\Component\Serializer\Annotation\DiscriminatorMap;

#[DiscriminatorMap(typeProperty: 'type', mapping: [
    ExtractionTypeEnum::HTML_CSS_SELECTOR->value => HtmlExtraction::class,
    ExtractionTypeEnum::HTML_COLLECTION_CSS_SELECTOR->value => HtmlCollectionExtraction::class,
])]
abstract class AbstractExtraction
{
    private string $name;
    private ExtractionTypeEnum $type;

    /**
     * @var CleanerConfiguration[]
     */
    private array $cleaners;

    /**
     * @var ValidatorConfiguration[]
     */
    private array $validators;

    /**
     * @param CleanerConfiguration[] $cleaners
     * @param ValidatorConfiguration[] $validators
     */
    public function __construct(
        string $name,
        ExtractionTypeEnum $type,
        array $cleaners = [],
        array $validators = []
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->cleaners = $cleaners;
        $this->validators = $validators;
    }

    abstract public function getConfig(): ExtractionConfigurationInterface;

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): ExtractionTypeEnum
    {
        return $this->type;
    }

    /**
     * @return CleanerConfiguration[]
     */
    public function getCleaners(): array
    {
        return $this->cleaners;
    }

    /**
     * @return ValidatorConfiguration[]
     */
    public function getValidators(): array
    {
        return $this->validators;
    }
}
