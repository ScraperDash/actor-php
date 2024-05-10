<?php

declare(strict_types=1);

use ScraperDash\Actor\Common\Exception\DefinitionAlreadyExistsException;
use ScraperDash\Actor\Common\Exception\DefinitionNotFoundException;
use ScraperDash\Actor\Common\LazyServiceRepository;
use ScraperDash\Actor\Extractor\Html\CssSelector;

describe(LazyServiceRepository::class, function () {
    describe('get', function () {
        it('Returns the appropriate instantiated Service based on the provided keyword', function () {
            $repository = new LazyServiceRepository();
            $repository->add('service.test', CssSelector::class);

            expect($repository->get('service.test'))
                ->toBeInstanceOf(CssSelector::class);
        });

        it('Returns the same instance if retrieved multiple times.', function () {
            $repository = new LazyServiceRepository();
            $repository->add('service.test', CssSelector::class);

            $instance = $repository->get('service.test');
            expect($instance)
                ->toBeInstanceOf(CssSelector::class);

            expect($repository->get('service.test'))
                ->toBeInstanceOf(CssSelector::class)
                ->toBe($instance)
            ;
        });

        it('Returns the originally provided instance', function () {
            $instance = new CssSelector();
            $repository = new LazyServiceRepository();
            $repository->add('service.test', CssSelector::class, $instance);

            expect($repository->get('service.test'))
                ->toBeInstanceOf(CssSelector::class)
                ->toBe($instance);
        });

        it('Throws an exception if the requested definition does not exist', function () {
            $repository = new LazyServiceRepository();
            $repository->get('service.test');
        })->throws(DefinitionNotFoundException::class);
    });

    describe('has', function () {
        it('Returns true if the requested definition exists', function () {
            $repository = new LazyServiceRepository();
            $repository->add('service.test', CssSelector::class);
            expect($repository->has('service.test'))->toBeTrue();
        });

        it('Returns false if the requested definition does not exist', function () {
            $repository = new LazyServiceRepository();
            expect($repository->has('service.test'))->toBeFalse();
        });
    });

    describe('add', function () {
        it('Throws an exception if the requested definition already exists', function () {
            $repository = new LazyServiceRepository();
            $repository->add('service.test', CssSelector::class);
            expect($repository->has('service.test'))->toBeTrue();

            $repository->add('service.test', CssSelector::class);
        })->throws(DefinitionAlreadyExistsException::class);
    });
});
