<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Profile;

use ScraperDash\Actor\Common\LazyServiceRepository;
use ScraperDash\Actor\Configuration\Model\Enum\RequestProfileEnum;
use ScraperDash\Actor\Profile\Model\BasicProfile;

/**
 * @extends LazyServiceRepository<ProfileInterface>
 */
class ProfileRepository extends LazyServiceRepository
{
    public function __construct()
    {
        $this->add(RequestProfileEnum::BASIC->value, BasicProfile::class);
    }

    public function getProfile(RequestProfileEnum $profile): ProfileInterface|null
    {
        if ($profile === RequestProfileEnum::NONE) {
            return null;
        }

        return $this->get($profile->value);
    }
}
