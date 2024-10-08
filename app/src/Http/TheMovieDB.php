<?php

namespace App\Http;

use App\Http\Model\Genre;
use App\Http\Model\Movie;
use App\Http\Model\Video;
use App\Serializer\BaseNormalizer;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

readonly class TheMovieDB
{
    public function __construct(
        private HttpClientInterface $theMovieDBApi,
        private SerializerInterface $serializer,
        private LoggerInterface     $logger
    ) {
        $classMetadataFactory = new ClassMetadataFactory(new AttributeLoader());

    }

    /**
     * @throws TransportExceptionInterface
     */
    public function get(string $path, array $options = []): ResponseInterface
    {
        return $this->theMovieDBApi->request(
            'GET',
            $path,
            $options
        );
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function handleResponse(ResponseInterface $response, string $type, array $context): mixed
    {
        if (200 != $response->getStatusCode()) {
            return null;
        }
        try {
            return $this->serializer->deserialize(
                $response->getContent(),
                $type,
                'json',
                $context
            );
        } catch (\Throwable $exception) {
            $this->logger->error(
                $exception->getMessage(),
                ['file' => $exception->getFile(), 'line' => $exception->getLine()]
            );
            return null;
        }
    }

    public function genres(): array
    {
        return $this->handleResponse(
            $this->get('/3/genre/movie/list'),
            Genre::class.'[]',
            [BaseNormalizer::NORMALIZATION_CONTEXT_KEY => BaseNormalizer::GENRES_COLLECTION_NORMALIZATION_CONTEXT]
        );
    }

    public function genre(int $id): ?Genre
    {
        $genres = $this->genres();
        $filteredGenres = array_filter($genres, fn($genre) => $id == $genre->id);

        return reset($filteredGenres) ?: null;
    }

    public function topRatedMovies(): array
    {
        return $this->handleResponse(
            $this->get('/3/movie/top_rated', ['query' => ['page' => 1]]),
            Movie::class.'[]',
            [BaseNormalizer::NORMALIZATION_CONTEXT_KEY => BaseNormalizer::MOVIES_COLLECTION_NORMALIZATION_CONTEXT]
        );
    }

    public function movies(string $query, int $page = 1): array
    {
        return $this->search(
            '/3/search/movie',
            [
                'query' => $query,
                'include_adult' => false,
                'sort_by' => 'popularity.desc',
                'page' => $page
            ]
        );
    }

    public function search(string $path, array $filters): array
    {
        return $this->handleResponse(
            $this->get($path, ['query' => $filters]),
            Movie::class.'[]',
            [BaseNormalizer::NORMALIZATION_CONTEXT_KEY => BaseNormalizer::MOVIES_COLLECTION_NORMALIZATION_CONTEXT]
        );
    }

    public function moviesByGenre(int $genreID): array
    {
        return $this->search(
            '/3/discover/movie',
            [
                'with_genres' => $genreID,
                'include_adult' => false,
                'sort_by' => 'popularity.desc',
            ]
        );
    }

    public function autocomplete(string $query): array
    {
        $movies = $this->movies($query);
        return array_map(fn(Movie $movie) => $movie->title, $movies);
    }

    public function movie(int $id): ?Movie
    {
        return $this->handleResponse(
            $this->get('/3/movie/'.$id),
            Movie::class,
            []
        );
    }

    public function teaser(int $movieId): ?Video
    {
        $trailers = $this->handleResponse(
            $this->get('/3/movie/'.$movieId.'/videos', ['query' => ['language' => 'en-US']]),
            Video::class.'[]',
            [BaseNormalizer::NORMALIZATION_CONTEXT_KEY => BaseNormalizer::VIDEOS_COLLECTION_NORMALIZATION_CONTEXT]
        );

        return array_shift($trailers) ?: null;
    }
}
