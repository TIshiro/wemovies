<?php

namespace App\Response;

use App\Http\Model\Genre;
use App\Http\Model\Movie;
use App\Http\Model\Video;

readonly class Response implements ResponseInterface
{
    public function __construct(
        private string  $h1,
        private array   $genres = [],
        private array   $movies = [],
        private ?Movie  $topRatedMovie = null,
        private ?Video  $topRatedMovieTeaser = null,
        private ?Genre  $genre = null,
        private ?string $query = null,
    )
    {
    }

    public function getContent(): array
    {
        return [
            'h1' => $this->h1,
            'genres' => $this->genres,
            'movies' => $this->movies,
            'topRatedMovie' => $this->topRatedMovie,
            'topRatedMovieTeaser' => $this->topRatedMovieTeaser,
            'genre' => $this->genre,
            'query' => $this->query,
        ];
    }
}