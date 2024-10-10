<?php

namespace App\Tests\Unit\ValueResolver;

use App\Http\Model\Genre;
use App\Http\TheMovieDB;
use App\ValueResolver\GenreValueResolver;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GenreValueResolverTest extends TestCase
{
    private TheMovieDB $theMovieDBMock;
    private GenreValueResolver $genreValueResolver;

    protected function setUp(): void
    {
        $this->theMovieDBMock = $this->createMock(TheMovieDB::class);
        $this->genreValueResolver = new GenreValueResolver($this->theMovieDBMock);
    }

    public function testResolveReturnsGenre()
    {
        $genreId = 1;
        $expectedGenre = $this->createMock(Genre::class);
        $this->theMovieDBMock->method('genre')->with($genreId)->willReturn($expectedGenre);

        $request = new Request([], [], ['id' => $genreId]);
        $argumentMetadata = $this->createArgumentMetadata(Genre::class);

        $result = $this->genreValueResolver->resolve($request, $argumentMetadata);

        $this->assertIsIterable($result);
        $this->assertCount(1, $result);
        $this->assertSame($expectedGenre, reset($result));
    }

    public function testResolveThrowsNotFoundHttpException()
    {
        $genreId = 999;
        $this->theMovieDBMock->method('genre')->with($genreId)->willReturn(null);

        $request = new Request([], [], ['id' => $genreId]);
        $argumentMetadata = $this->createArgumentMetadata(Genre::class);

        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage('Genre not found.');

        iterator_to_array($this->genreValueResolver->resolve($request, $argumentMetadata));
    }

    public function testResolveReturnsEmptyArrayWhenArgumentNotSupported()
    {
        $request = new Request();
        $argumentMetadata = $this->createArgumentMetadata('OtherType');

        $result = $this->genreValueResolver->resolve($request, $argumentMetadata);

        $this->assertIsIterable($result);
        $this->assertCount(0, $result);
    }

    private function createArgumentMetadata(string $type): ArgumentMetadata
    {
        return new ArgumentMetadata(
            'argument',
            $type,
            false,
            false,
            null
        );
    }
}