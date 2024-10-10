<?php

namespace App\MessageHandler;

use App\Http\TheMovieDB;
use App\Message\SearchMovieMessage;
use App\Response\SearchMovieResponse;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class SearchMovieMessageHandler
{
    use ResponseTrait;

    public function __construct(private TheMovieDB $theMovieDB)
    {
    }

    public function __invoke(SearchMovieMessage $message): SearchMovieResponse
    {
        $query = $message->getQuery();
        $topRatedMovies = $this->theMovieDB->movies($query);
        return $this->render(
            SearchMovieResponse::class,
            'We movies: Result for ' . $query,
            $this->theMovieDB->movies($query),
            null,
            $query
        );
    }
}