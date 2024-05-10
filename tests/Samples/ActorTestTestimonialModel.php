<?php

declare(strict_types=1);

namespace Tests\Samples;

class ActorTestTestimonialModel
{
    private string $comment;
    private string $author;
    private string $link;

    public function __construct(
        string $comment,
        string $author,
        string $link
    ) {
        $this->comment = $comment;
        $this->author = $author;
        $this->link = $link;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getLink(): string
    {
        return $this->link;
    }
}
