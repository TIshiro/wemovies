<?php

namespace App\Message;

readonly class AutocompleteMessage implements MessageInterface
{
    public function __construct(private string $query)
    {
    }

    public function getQuery(): string
    {
        return $this->query;
    }
}