<?php

namespace App\Tests\Unit\MessageHandler;

use App\MessageHandler\AutocompleteMessageHandler;
use App\MessageHandler\GetGenreContentMessageHandler;
use App\MessageHandler\GetHomeContentMessageHandler;
use App\MessageHandler\GetMovieVideoMessageHandler;
use App\MessageHandler\SearchMovieMessageHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class AppMessageHandlerTest extends TestCase
{
    /**
     * @dataProvider getAppMessageHandlers
     */
    public function testClassIsAnnotatedWithAsMessageHandler($class): void
    {
        $reflectionClass = new \ReflectionClass($class);
        $attributes = $reflectionClass->getAttributes(AsMessageHandler::class);

        $this->assertCount(
            1,
            $attributes,
            $class . 'should be annotated with #[AsMessageHandler].');
    }
    public function getAppMessageHandlers(): array
    {
        return [
            'AutocompleteMessageHandler' => [
                AutocompleteMessageHandler::class,
            ],
            'GetGenreContentMessageHandler' => [
                GetGenreContentMessageHandler::class,
            ],
            'GetHomeContentMessageHandler' => [
                GetHomeContentMessageHandler::class,
            ],
            'GetMovieVideoMessageHandler' => [
                GetMovieVideoMessageHandler::class,
            ],
            'SearchMovieMessageHandler' => [
                SearchMovieMessageHandler::class,
            ],
        ];
    }
}