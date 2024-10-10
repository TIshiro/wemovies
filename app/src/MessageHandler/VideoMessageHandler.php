<?php

namespace App\MessageHandler;

use App\Http\Model\Video;
use App\Http\TheMovieDB;
use App\Message\VideoMessage;
use App\Response\VideoResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class VideoMessageHandler
{
    public function __construct(private TheMovieDB $theMovieDB)
    {
    }

    public function __invoke(VideoMessage $message): VideoResponse
    {
        $id = $message->getMovieId();
        $video = $this->theMovieDB->teaser($id);
        if (!$video instanceof Video) {
            throw new NotFoundHttpException();
        }

        return new VideoResponse($video);
    }
}