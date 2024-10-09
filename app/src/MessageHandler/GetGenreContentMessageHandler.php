<?php

namespace App\MessageHandler;

use App\Http\TheMovieDB;
use App\Message\GetGenreContentMessage;
use App\Response\GetGenreContentResponse;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetGenreContentMessageHandler
{
    use ResponseTrait;

    public function __construct(private TheMovieDB $theMovieDB)
    {
    }

    public function __invoke(GetGenreContentMessage $message): GetGenreContentResponse
    {
        $genre = $message->getGenre();
        return $this->render(
            GetGenreContentResponse::class,
            'We movies: ' . ucfirst($genre->name),
            $this->theMovieDB->moviesByGenre($genre->id),
            $genre
        );
    }
}