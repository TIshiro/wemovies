<?php

namespace App\Message;

use App\Http\Model\Genre;

readonly class GetGenreContentMessage implements MessageInterface
{
    public function __construct(private Genre $genre)
    {
    }
    public function getGenre(): Genre
    {
        return $this->genre;
    }
}