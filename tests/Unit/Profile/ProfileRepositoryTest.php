<?php

declare(strict_types=1);

use ScraperDash\Actor\Configuration\Model\Enum\RequestProfileEnum;
use ScraperDash\Actor\Profile\Model\BasicProfile;
use ScraperDash\Actor\Profile\ProfileRepository;

describe(ProfileRepository::class, function () {
    $repository = new ProfileRepository();

    it('Returns the appropriate Profile based on the provided configuration', function () use ($repository) {
        expect($repository->getProfile(RequestProfileEnum::BASIC))
            ->toBeInstanceOf(BasicProfile::class);
    });

    it('Returns null if the NONE profile is used', function () use ($repository) {
        expect($repository->getProfile(RequestProfileEnum::NONE))->toBeNull();
    });
});
