<?php

namespace App\Response;

readonly class AutocompleteResponse implements ResponseInterface
{
    public function __construct(private array $content)
    {
    }

    public function getContent(): array
    {
        return $this->content;
    }
}