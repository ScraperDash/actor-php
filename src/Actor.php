<?php

declare(strict_types=1);

namespace ScraperDash\Actor;

use Assert\Assertion;
use Nyholm\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use ScraperDash\Actor\Cleaner\CleanerRepository;
use ScraperDash\Actor\Configuration\Model\Configuration;
use ScraperDash\Actor\Configuration\Model\Enum\OutputTypeEnum;
use ScraperDash\Actor\Exception\ValidationException;
use ScraperDash\Actor\Extractor\ExtractorRepository;
use ScraperDash\Actor\Extractor\ExtractorResultResolver;
use ScraperDash\Actor\Profile\ProfileRepository;
use ScraperDash\Actor\Utility\SerializerFactory;
use ScraperDash\Actor\Validator\ValidatorRepository;
use Symfony\Component\Serializer\Serializer;

class Actor
{
    private ProfileRepository $profileRepository;
    private ExtractorResultResolver $extractorResultResolver;
    private Serializer $serializer;

    public function __construct(
        private Configuration $configuration,
        private ClientInterface $client,
        CleanerRepository|null $cleanerRepository = null,
        ExtractorRepository|null $extractorRepository = null,
        ProfileRepository|null $profileRepository = null,
        ValidatorRepository|null $validatorRepository = null
    ) {
        $this->profileRepository = $profileRepository ?? new ProfileRepository();
        $this->extractorResultResolver = new ExtractorResultResolver(
            $cleanerRepository ?? new CleanerRepository(),
            $extractorRepository ?? new ExtractorRepository(),
            $validatorRepository ?? new ValidatorRepository()
        );
        $this->serializer = (new SerializerFactory())->create();
    }

    /**
     * @return object|array<string, mixed>
     */
    public function act(string $method, string $url): object|array
    {
        $request = new Request($method, $url);
        $profile = $this->profileRepository->getProfile($this->configuration->getRequest()->getProfile());
        if ($profile !== null) {
            foreach ($profile->getHeaders() as $header => $value) {
                $request = $request->withAddedHeader($header, $value);
            }
        }

        $response = $this->client->sendRequest($request);

        $result = $this->extractorResultResolver->resolveResponse($this->configuration->getExtractions(), $response);
        if (count($result->getErrors()) > 0) {
            throw new ValidationException($result->getErrors(), $result->getData());
        }

        if ($this->configuration->getOutput()->getType() === OutputTypeEnum::MAP) {
            return $result->getData();
        }

        Assertion::notNull($this->configuration->getOutput()->getModel());

        $extractionResult = $this->serializer->denormalize(
            $result->getData(),
            $this->configuration->getOutput()->getModel()
        );
        Assertion::isObject($extractionResult);
        Assertion::isInstanceOf($extractionResult, $this->configuration->getOutput()->getModel());

        return $extractionResult;
    }
}
