<?php

declare(strict_types=1);

namespace Tests\Samples;

class ActorTestModel
{
    private string $startedButton;

    /**
     * @var ActorTestTestimonialModel[]
     */
    private array $testimonials;
    private string $copyright;

    /**
     * @param ActorTestTestimonialModel[] $testimonials
     */
    public function __construct(
        string $startedButton,
        array $testimonials,
        string $copyright
    ) {
        $this->startedButton = $startedButton;
        $this->testimonials = $testimonials;
        $this->copyright = $copyright;
    }

    public function getStartedButton(): string
    {
        return $this->startedButton;
    }

    /**
     * @return ActorTestTestimonialModel[]
     */
    public function getTestimonials(): array
    {
        return $this->testimonials;
    }

    public function getCopyright(): string
    {
        return $this->copyright;
    }
}
