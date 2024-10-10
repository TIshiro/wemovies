<?php

namespace App\Tests\Unit\Message;

use App\Http\Model\Genre;
use App\Message\AutocompleteMessage;
use App\Message\GetGenreContentMessage;
use App\Message\GetHomeContentMessage;
use App\Message\GetMovieVideoMessage;
use App\Message\MessageInterface;
use App\Message\SearchMovieMessage;
use PHPUnit\Framework\TestCase;

class AppMessageTest extends TestCase
{
    /**
     * @dataProvider getAppMessages
     */
    public function testAppMessagesMustImplementsMessageInterface(
        object $message,
        string $class
    ): void {
        $this->assertInstanceOf(
            MessageInterface::class,
            $message,
            $class . ' should implement MessageInterface.'
        );
    }

    public function getAppMessages(): array
    {
        return [
            'AutocompleteMessage' => [
                new AutocompleteMessage('foo'),
                AutocompleteMessage::class,
            ],
            'GetGenreContentMessage' => [
                new GetGenreContentMessage(new Genre()),
                GetGenreContentMessage::class,
            ],
            'GetHomeContentMessage' => [
                new GetHomeContentMessage(),
                GetHomeContentMessage::class,
            ],
            'GetMovieVideoMessage' => [
                new GetMovieVideoMessage(1),
                GetMovieVideoMessage::class,
            ],
            'SearchMovieMessage' => [
                new SearchMovieMessage('foo-bar'),
                SearchMovieMessage::class,
            ],
        ];
    }
}