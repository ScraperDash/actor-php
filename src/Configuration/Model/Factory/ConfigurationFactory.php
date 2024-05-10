<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Configuration\Model\Factory;

use ScraperDash\Actor\Configuration\Model\Configuration;
use ScraperDash\Actor\Exception\InvalidConfigurationException;
use ScraperDash\Actor\Utility\SerializerFactory;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Serializer;

class ConfigurationFactory
{
    private Serializer $serializer;

    public function __construct()
    {
        $this->serializer = (new SerializerFactory())->create();
    }

    public function create(string $configuration): Configuration
    {
        try {
            return $this->serializer->deserialize($configuration, Configuration::class, 'json');
        } catch (RuntimeException $exception) {
            throw new InvalidConfigurationException(previous: $exception);
        }
    }
}
