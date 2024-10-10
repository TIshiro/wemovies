<?php

namespace App\Message;

readonly class VideoMessage implements MessageInterface
{
    public function __construct(private int $movieId)
    {
    }

    public function getMovieId(): int
    {
        return $this->movieId;
    }
}