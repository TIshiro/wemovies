<?php

namespace App\MessageHandler;

use App\Http\TheMovieDB;
use App\Message\GetHomeContentMessage;
use App\Response\GetHomeContentResponse;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetHomeContentMessageHandler
{
    public function __construct(private TheMovieDB $theMovieDB)
    {
    }

    public function __invoke(GetHomeContentMessage $message): GetHomeContentResponse
    {
        $topRatedMovies = $this->theMovieDB->topRatedMovies();
        $topRatedMovie = array_shift($topRatedMovies);
        $topRatedMovieTeaser = $topRatedMovie ? $this->theMovieDB->teaser($topRatedMovie->id) : null;

        if (!$topRatedMovieTeaser && $topRatedMovie) {
            array_unshift($topRatedMovies, $topRatedMovie);
        }

        return new GetHomeContentResponse(
            GetHomeContentResponse::H1,
            $this->theMovieDB->genres(),
            $topRatedMovies,
            $topRatedMovie,
            $topRatedMovieTeaser,
        );
    }
}