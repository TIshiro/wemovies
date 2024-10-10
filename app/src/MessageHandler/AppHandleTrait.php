<?php

namespace App\MessageHandler;

use App\Message\MessageInterface;
use App\Response\ResponseInterface;
use Symfony\Component\Messenger\HandleTrait;

trait AppHandleTrait
{
    use HandleTrait;

    private function handleMessage(MessageInterface $message): ResponseInterface
    {
        return $this->handle($message);
    }
}