<?php

namespace App\Response;

use App\Http\Model\Video;

readonly class VideoResponse implements ResponseInterface
{
    public function __construct(private Video $video)
    {
    }
    public function getContent(): array
    {
        return [$this->video];
    }
}