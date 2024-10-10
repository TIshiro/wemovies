<?php

namespace App\MessageHandler;

use App\Http\Model\Video;
use App\Http\TheMovieDB;
use App\Message\GetMovieVideoMessage;
use App\Response\GetMovieVideoResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetMovieVideoMessageHandler
{
    public function __construct(private TheMovieDB $theMovieDB)
    {
    }

    public function __invoke(GetMovieVideoMessage $message): GetMovieVideoResponse
    {
        $id = $message->getMovieId();
        $video = $this->theMovieDB->teaser($id);
        if (!$video instanceof Video) {
            throw new NotFoundHttpException();
        }

        return new GetMovieVideoResponse($video);
    }
}