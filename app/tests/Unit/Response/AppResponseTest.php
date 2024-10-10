<?php

namespace App\Tests\Unit\Response;

use App\Http\Model\Video;
use App\Response\AutocompleteResponse;
use App\Response\GetGenreContentResponse;
use App\Response\GetHomeContentResponse;
use App\Response\GetMovieVideoResponse;
use App\Response\ResponseInterface;
use App\Response\SearchMovieResponse;
use PHPUnit\Framework\TestCase;

class AppResponseTest extends TestCase
{
    /**
     * @dataProvider getAppMessages
     */
    public function testAppResponseMustImplementsResponseInterface(
        object $response,
        string $class
    ): void {
        $this->assertInstanceOf(
            ResponseInterface::class,
            $response,
            $class . ' should implement' . ResponseInterface::class . '.'
        );
    }

    public function getAppMessages(): array
    {
        return [
            'GetGenreContentResponse' => [
                new GetGenreContentResponse('foo'),
                GetGenreContentResponse::class,
            ],
            'GetHomeContentResponse' => [
                new GetHomeContentResponse('bar'),
                GetHomeContentResponse::class,
            ],
            'SearchMovieResponse' => [
                new SearchMovieResponse('baz'),
                SearchMovieResponse::class,
            ],
            'GetMovieVideoResponse' => [
                new GetMovieVideoResponse(new Video()),
                GetMovieVideoResponse::class,
            ],
            'AutocompleteResponse' => [
                new AutocompleteResponse([]),
                AutocompleteResponse::class,
            ],
        ];
    }
}