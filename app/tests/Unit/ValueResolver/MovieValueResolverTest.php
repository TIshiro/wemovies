<?php

namespace App\Tests\Unit\ValueResolver;

use App\Http\Model\Movie;
use App\Http\TheMovieDB;
use App\ValueResolver\MovieValueResolver;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MovieValueResolverTest extends TestCase
{
    private TheMovieDB $theMovieDBMock;
    private MovieValueResolver $movieValueResolver;

    protected function setUp(): void
    {
        $this->theMovieDBMock = $this->createMock(TheMovieDB::class);
        $this->movieValueResolver = new MovieValueResolver($this->theMovieDBMock);
    }

    public function testResolveReturnsMovie()
    {
        $movieId = 1;
        $expectedMovie = $this->createMock(Movie::class);
        $this->theMovieDBMock->method('movie')->with($movieId)->willReturn($expectedMovie);

        $request = new Request([], [], ['id' => $movieId]);
        $argumentMetadata = $this->createArgumentMetadata(Movie::class);

        $result = $this->movieValueResolver->resolve($request, $argumentMetadata);

        $this->assertIsIterable($result);
        $this->assertCount(1, $result);
        $this->assertSame($expectedMovie, reset($result));
    }

    public function testResolveThrowsNotFoundHttpException()
    {
        $movieId = 999;
        $this->theMovieDBMock->method('movie')->with($movieId)->willReturn(null);

        $request =         $request = new Request([], [], ['id' => $movieId]);
        $argumentMetadata = $this->createArgumentMetadata(Movie::class);

        $this->expectException(NotFoundHttpException::class);

        iterator_to_array($this->movieValueResolver->resolve($request, $argumentMetadata));
    }

    public function testResolveReturnsEmptyArrayWhenArgumentNotSupported()
    {
        $request = new Request();
        $argumentMetadata = $this->createArgumentMetadata('OtherType');

        $result = $this->movieValueResolver->resolve($request, $argumentMetadata);

        $this->assertIsIterable($result);
        $this->assertCount(0, $result);
    }

    private function createArgumentMetadata(string $type): ArgumentMetadata
    {
        return new ArgumentMetadata('movie', $type, false, false, null);
    }
}