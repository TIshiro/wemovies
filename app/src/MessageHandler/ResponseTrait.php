<?php

namespace App\MessageHandler;

use App\Http\Model\Genre;
use App\Http\TheMovieDB;
use App\Response\ResponseInterface;

trait ResponseTrait
{
    private readonly TheMovieDB $theMovieD;

    private function render(
        string $responseClass,
        string $h1,
        array $movies,
        ?Genre $genre = null,
        ?string $query = null
    ): ResponseInterface {
        $topRatedMovie = array_shift($movies);
        $topRatedMovieTeaser = $topRatedMovie ? $this->theMovieDB->teaser($topRatedMovie->id) : null;

        if (!$topRatedMovieTeaser && $topRatedMovie) {
            array_unshift($movies, $topRatedMovie);
        }

        return new $responseClass(
            $h1,
            $this->theMovieDB->genres(),
            $movies,
            $topRatedMovie,
            $topRatedMovieTeaser,
            $genre,
            $query
        );
    }
}