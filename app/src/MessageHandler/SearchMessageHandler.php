<?php

namespace App\MessageHandler;

use App\Http\TheMovieDB;
use App\Message\SearchMessage;
use App\Response\SearchResponse;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class SearchMessageHandler
{
    use ResponseTrait;

    public function __construct(private TheMovieDB $theMovieDB)
    {
    }

    public function __invoke(SearchMessage $message): SearchResponse
    {
        $query = $message->getQuery();
        $topRatedMovies = $this->theMovieDB->movies($query);
        return $this->render(
            SearchResponse::class,
            'We movies: Result for ' . $query,
            $this->theMovieDB->movies($query),
            null,
            $query
        );
    }
}