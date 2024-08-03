<?php

declare(strict_types=1);

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use ScraperDash\Actor\Actor;
use ScraperDash\Actor\Configuration\Model\Factory\ConfigurationFactory;
use ScraperDash\Actor\Exception\ValidationException;
use ScraperDash\Actor\Profile\Model\BasicProfile;
use Tests\Samples\ActorTestModel;
use Tests\Samples\ActorTestTestimonialModel;

describe(Actor::class, function () {
    it('Can output map', function () {
        $client = Mockery::mock(ClientInterface::class);
        $response = Mockery::mock(ResponseInterface::class);
        $responseStream = Mockery::mock(StreamInterface::class);
        $responseStream->shouldReceive('getContents')->andReturn(getSample('pest.html'));
        $response->shouldReceive('getBody')->andReturn($responseStream);
        $client->shouldReceive('sendRequest')->andReturn($response);

        $configuration = (new ConfigurationFactory())->create(getSample('configuration-map.json'));

        $actor = new Actor($configuration, $client);
        $result = $actor->act('GET', 'https://pestphp.com');

        expect($result)->toBeArray()
            ->and($result['startedButton'])->toBeString()->toEqual('Get started')
            ->and($result['testimonials'])->toBeArray()->toHaveCount(4)
            ->and($result['testimonials'][0]['comment'])->toBeString()->toEqual(
                '“Pest is minimal, distraction-free, and a joy to use.”'
            )
            ->and($result['testimonials'][0]['author'])->toBeString()->toEqual(
                'Taylor Otwell  · Creator of Laravel'
            )
            ->and($result['testimonials'][0]['link'])->toBeString()->toEqual('https://laravel.com?ref=pestphp')
            ->and($result['testimonials'][1]['comment'])->toBeString()->toEqual(
                '“It took me a year to finally give Pest a try… and ten minutes to make the switch. Pest is the way.”'
            )
            ->and($result['testimonials'][1]['author'])->toBeString()->toEqual('Jeffrey Way · Laracasts Owner')
            ->and($result['testimonials'][1]['link'])->toBeString()->toEqual('https://laracasts.com?ref=pestphp')
            ->and($result['testimonials'][2]['comment'])->toBeString()->toEqual(
                '“I wouldn\'t be surprised if Pest becomes the default test runner in PHP in the near future.”'
            )
            ->and($result['testimonials'][2]['author'])->toBeString()->toEqual(
                'Freek Van der Herten · Developer at Spatie'
            )
            ->and($result['testimonials'][2]['link'])->toBeString()->toEqual('https://spatie.be?ref=pestphp')
            ->and($result['testimonials'][3]['comment'])->toBeString()->toEqual(
                '“Testing becomes an addiction in every project.”'
            )
            ->and($result['testimonials'][3]['author'])->toBeString()->toEqual(
                'Caneco · Full-Stack Developer at Medicare'
            )
            ->and($result['testimonials'][3]['link'])->toBeString()->toEqual('https://medicare.pt?ref=pestphp')
            ->and($result['copyright'])->toBeString()->toEqual('© 2023 Pest');
    });

    it('Can output a model', function () {
        $client = Mockery::mock(ClientInterface::class);
        $response = Mockery::mock(ResponseInterface::class);
        $responseStream = Mockery::mock(StreamInterface::class);
        $responseStream->shouldReceive('getContents')->andReturn(getSample('pest.html'));
        $response->shouldReceive('getBody')->andReturn($responseStream);
        $client->shouldReceive('sendRequest')->andReturn($response);

        $configuration = (new ConfigurationFactory())->create(getSample('configuration-model.json'));

        $actor = new Actor($configuration, $client);
        $result = $actor->act('GET', 'https://pestphp.com');

        expect($result)->toBeInstanceOf(ActorTestModel::class)
            ->and($result->getStartedButton())->toBeString()->toEqual('Get started')
            ->and($result->getTestimonials())->toBeArray()->toHaveCount(4)
            ->and($result->getTestimonials()[0])->toBeInstanceOf(ActorTestTestimonialModel::class)
            ->and($result->getTestimonials()[0]->getComment())->toBeString()->toEqual(
                '“Pest is minimal, distraction-free, and a joy to use.”'
            )
            ->and($result->getTestimonials()[0]->getAuthor())->toBeString()->toEqual(
                'Taylor Otwell  · Creator of Laravel'
            )
            ->and($result->getTestimonials()[0]->getLink())->toBeString()->toEqual(
                'https://laravel.com?ref=pestphp'
            )
            ->and($result->getTestimonials()[1])->toBeInstanceOf(ActorTestTestimonialModel::class)
            ->and($result->getTestimonials()[1]->getComment())->toBeString()->toEqual(
                '“It took me a year to finally give Pest a try… and ten minutes to make the switch. Pest is the way.”'
            )
            ->and($result->getTestimonials()[1]->getAuthor())->toBeString()->toEqual(
                'Jeffrey Way · Laracasts Owner'
            )
            ->and($result->getTestimonials()[1]->getLink())->toBeString()->toEqual(
                'https://laracasts.com?ref=pestphp'
            )
            ->and($result->getTestimonials()[2])->toBeInstanceOf(ActorTestTestimonialModel::class)
            ->and($result->getTestimonials()[2]->getComment())->toBeString()->toEqual(
                '“I wouldn\'t be surprised if Pest becomes the default test runner in PHP in the near future.”'
            )
            ->and($result->getTestimonials()[2]->getAuthor())->toBeString()->toEqual(
                'Freek Van der Herten · Developer at Spatie'
            )
            ->and($result->getTestimonials()[2]->getLink())->toBeString()->toEqual('https://spatie.be?ref=pestphp')
            ->and($result->getTestimonials()[3])->toBeInstanceOf(ActorTestTestimonialModel::class)
            ->and($result->getTestimonials()[3]->getComment())->toBeString()->toEqual(
                '“Testing becomes an addiction in every project.”'
            )
            ->and($result->getTestimonials()[3]->getAuthor())->toBeString()->toEqual(
                'Caneco · Full-Stack Developer at Medicare'
            )
            ->and($result->getTestimonials()[3]->getLink())->toBeString()->toEqual(
                'https://medicare.pt?ref=pestphp'
            )
            ->and($result->getCopyright())->toBeString()->toEqual('© 2023 Pest');
    });

    it('Adds headers based on the selected profile', function () {
        $client = Mockery::mock(ClientInterface::class);
        $response = Mockery::mock(ResponseInterface::class);
        $responseStream = Mockery::mock(StreamInterface::class);
        $responseStream->shouldReceive('getContents')->andReturn(getSample('pest.html'));
        $response->shouldReceive('getBody')->andReturn($responseStream);
        $client->shouldReceive('sendRequest')->withArgs(function (RequestInterface $request): bool {
            $basicProfile = new BasicProfile();
            foreach ($basicProfile->getHeaders() as $header => $value) {
                if ($request->getHeaderLine($header) !== $value) {
                    return false;
                }
            }

            return true;
        })->andReturn($response);

        $configuration = (new ConfigurationFactory())->create(getSample('configuration-basic-profile.json'));

        $actor = new Actor($configuration, $client);
        $result = $actor->act('GET', 'https://pestphp.com');

        expect($result)->toBeArray()
            ->and($result['startedButton'])->toBeString()->toEqual('Get started');
    });

    it('Passes request configuration through to underlying client', function () {
        $client = Mockery::mock(ClientInterface::class);
        $response = Mockery::mock(ResponseInterface::class);
        $responseStream = Mockery::mock(StreamInterface::class);
        $responseStream->shouldReceive('getContents')->andReturn(getSample('pest.html'));
        $response->shouldReceive('getBody')->andReturn($responseStream);

        $requestBody = '{"message": "This is a test body"}';
        $requestHeaders = [
            'Authorization' => 'not-real-auth',
            'X-FAKE-HEADER' => 'fake-value',
        ];
        $requestVersion = '2';
        $client->shouldReceive('sendRequest')->withArgs(function (RequestInterface $request) use (
            $requestBody,
            $requestHeaders,
            $requestVersion
        ): bool {
            $request->getBody()->rewind();
            if ($request->getBody()->getContents() !== $requestBody) {
                return false;
            }

            // Make sure the Profile headers are also included
            $basicProfile = new BasicProfile();
            foreach ($basicProfile->getHeaders() as $header => $value) {
                if ($request->getHeaderLine($header) !== $value) {
                    return false;
                }
            }

            foreach ($requestHeaders as $header => $value) {
                if ($request->getHeaderLine($header) !== $value) {
                    return false;
                }
            }

            return $request->getProtocolVersion() === $requestVersion;
        })->andReturn($response);

        $configuration = (new ConfigurationFactory())->create(getSample('configuration-basic-profile.json'));

        $actor = new Actor($configuration, $client);
        $result = $actor->act('GET', 'https://pestphp.com', $requestHeaders, $requestBody, $requestVersion);

        expect($result)->toBeArray()
            ->and($result['startedButton'])->toBeString()->toEqual('Get started');
    });

    it('Throws an exception when there are validation issues', function () {
        $client = Mockery::mock(ClientInterface::class);
        $response = Mockery::mock(ResponseInterface::class);
        $responseStream = Mockery::mock(StreamInterface::class);
        $responseStream->shouldReceive('getContents')->andReturn(getSample('pest.html'));
        $response->shouldReceive('getBody')->andReturn($responseStream);
        $client->shouldReceive('sendRequest')->andReturn($response);
        $configuration = (new ConfigurationFactory())->create(getSample('configuration-fails-validation.json'));

        $actor = new Actor($configuration, $client);

        try {
            $actor->act('GET', 'https://pestphp.com');
        } catch (ValidationException $exception) {
            expect($exception->getErrors())->toBeArray()
                ->and($exception->getErrors()['category'][0])->toEqual('This value must not be empty.')
                ->and($exception->getErrors()['testimonials'][0]['name'][0])->toEqual('This value must not be empty.')
                ->and($exception->getErrors()['testimonials'][1]['name'][0])->toEqual('This value must not be empty.')
                ->and($exception->getErrors()['testimonials'][2]['name'][0])->toEqual('This value must not be empty.')
                ->and($exception->getErrors()['testimonials'][3]['name'][0])->toEqual('This value must not be empty.')
            ;

            throw $exception;
        }
    })->throws(ValidationException::class);
});
