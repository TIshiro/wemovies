<?php

namespace App\MessageHandler;

use App\Http\TheMovieDB;
use App\Message\GetGenreContentMessage;
use App\Response\GetGenreContentResponse;
use App\Response\GetHomeContentResponse;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetGenreContentMessageHandler
{
    public function __construct(private TheMovieDB $theMovieDB)
    {
    }

    public function __invoke(GetGenreContentMessage $message): GetGenreContentResponse
    {
        $genre = $message->getGenre();
        $topRatedMovies = $this->theMovieDB->moviesByGenre($genre->id);
        $topRatedMovie = array_shift($topRatedMovies);
        $topRatedMovieTeaser = $topRatedMovie ? $this->theMovieDB->teaser($topRatedMovie->id) : null;

        if (!$topRatedMovieTeaser && $topRatedMovie) {
            array_unshift($topRatedMovies, $topRatedMovie);
        }
        return new GetGenreContentResponse(
            'We movies: ' . ucfirst($genre->name),
            $this->theMovieDB->genres(),
            $topRatedMovies,
            $topRatedMovie,
            $topRatedMovieTeaser,
            $genre,
        );
    }
}