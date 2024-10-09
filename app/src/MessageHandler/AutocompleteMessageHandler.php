<?php

namespace App\MessageHandler;

use App\Http\TheMovieDB;

use App\Message\AutocompleteMessage;
use App\Response\AutocompleteResponse;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class AutocompleteMessageHandler
{
    public function __construct(private TheMovieDB $theMovieDB)
    {
    }

    public function __invoke(AutocompleteMessage $message): AutocompleteResponse
    {
        $query = $message->getQuery();
        return new AutocompleteResponse($this->theMovieDB->autocomplete($query));
    }
}