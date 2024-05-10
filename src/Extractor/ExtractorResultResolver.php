<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Extractor;

use Psr\Http\Message\ResponseInterface;
use ScraperDash\Actor\Cleaner\CleanerRepository;
use ScraperDash\Actor\Configuration\Model\AbstractExtraction;
use ScraperDash\Actor\Extractor\Html\CollectionCssSelector;
use ScraperDash\Actor\Extractor\Model\ResolvedExtractorResult;
use ScraperDash\Actor\Validator\ValidatorRepository;

class ExtractorResultResolver
{
    public function __construct(
        private CleanerRepository $cleanerRepository,
        private ExtractorRepository $extractorRepository,
        private ValidatorRepository $validatorRepository
    ) {
    }

    /**
     * @param AbstractExtraction[] $extractions
     */
    public function resolveResponse(array $extractions, ResponseInterface $response): ResolvedExtractorResult
    {
        $dom = new \DOMDocument();
        $dom->loadHTML($response->getBody()->getContents(), LIBXML_NOWARNING | LIBXML_NOERROR);

        return $this->resolve($extractions, $dom);
    }

    /**
     * @param AbstractExtraction[] $extractions
     */
    public function resolve(array $extractions, \DOMDocument $dom): ResolvedExtractorResult
    {
        $data = [];
        $validationErrors = [];

        foreach ($extractions as $extractionConfiguration) {
            $field = $extractionConfiguration->getName();
            $extractor = $this->extractorRepository->getExtractor($extractionConfiguration->getType());
            if ($extractor instanceof CollectionCssSelector) {
                $extractor->setResultResolver($this);
            }

            $extractionResult = $extractor->extract($extractionConfiguration->getConfig(), $dom);
            $extractedData = $extractionResult->getData();
            foreach ($extractionConfiguration->getCleaners() as $cleanerConfiguration) {
                $cleaner = $this->cleanerRepository->getCleaner($cleanerConfiguration->getType());

                $extractedData = $cleaner->clean($cleanerConfiguration->getConfig(), $extractedData);
            }

            foreach ($extractionConfiguration->getValidators() as $validatorConfiguration) {
                $validator = $this->validatorRepository->getValidator($validatorConfiguration->getType());

                $validationResult = $validator->validate($validatorConfiguration->getConfig(), $extractedData);
                if ($validationResult !== true) {
                    $validationErrors[$field][] = $validator->getMessage($validatorConfiguration->getConfig());
                }
            }

            if (count($extractionResult->getErrors()) > 0 || count($validationErrors[$field] ?? []) > 0) {
                $validationErrors[$field] = array_merge(
                    $extractionResult->getErrors(),
                    $validationErrors[$field] ?? []
                );
            }

            $data[$field] = $extractedData;
        }

        return new ResolvedExtractorResult($data, $validationErrors);
    }
}
