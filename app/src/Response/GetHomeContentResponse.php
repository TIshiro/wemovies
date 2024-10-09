<?php

namespace App\Response;

use App\Http\Model\Genre;
use App\Http\Model\Movie;
use App\Http\Model\Video;

class GetHomeContentResponse implements ResponseInterface
{
    public const  H1 = 'À propos de We Movies';

    public function __construct(
        private readonly string  $h1,
        private readonly array   $genres = [],
        private readonly array   $movies = [],
        private readonly ?Movie  $topRatedMovie = null,
        private readonly ?Video  $topRatedMovieTeaser = null,
        private readonly ?string $query = null,
        private readonly ?Genre   $genre = null,
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