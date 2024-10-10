<?php

namespace App\MessageHandler;

use App\Http\TheMovieDB;
use App\Message\GetHomeContentMessage;
use App\Response\GetHomeContentResponse;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetHomeContentMessageHandler
{
    use ResponseTrait;

    public function __construct(private TheMovieDB $theMovieDB)
    {
    }

    public function __invoke(GetHomeContentMessage $message): GetHomeContentResponse
    {
        return $this->render(
            GetHomeContentResponse::class,
            GetHomeContentResponse::H1,
            $this->theMovieDB->topRatedMovies()
        );
    }
}