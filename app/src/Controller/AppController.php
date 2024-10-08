<?php

namespace App\Controller;

use App\Http\Model\Genre;
use App\Http\Model\Movie;
use App\Http\Model\Video;
use App\Http\TheMovieDB;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    private array $genres;

    public function __construct(private readonly TheMovieDB $theMovieDB)
    {
        $this->genres = $this->theMovieDB->genres(); // Récupérer les genres une seule fois
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->renderMoviesPage(
            'À propos de We Movies',
            $this->theMovieDB->topRatedMovies()
        );
    }

    #[Route('/genre/{id}/movies', name: 'app_movies_by_genre')]
    public function moviesByGenre(int $id): Response
    {
        $genre = $this->theMovieDB->genre($id);
        if (!$genre instanceof Genre) {
            throw new NotFoundHttpException();
        }
        return $this->renderMoviesPage(
            'We movies: ' . ucfirst($genre->name),
            $this->theMovieDB->moviesByGenre($id),
            $genre
        );
    }

    #[Route('/search', name: 'app_search')]
    public function search(Request $request): Response
    {
        $query = $request->query->get('q');
        return $this->renderMoviesPage(
            'We movies: Result for ' . $query,
            $this->theMovieDB->movies($query),
            null,
            $query
        );
    }

    #[Route('/autocomplete', name: 'app_autocomplete')]
    public function autocomplete(Request $request): JsonResponse
    {
        $query = $request->query->get('q');
        return $this->json($this->theMovieDB->autocomplete($query));
    }

    #[Route('/movie/{id}', name: 'app_movie')]
    public function movie(int $id): JsonResponse
    {
        $movie = $this->theMovieDB->movie($id);
        if (!$movie instanceof Movie) {
            throw new NotFoundHttpException();
        }
        return $this->json($movie);
    }

    #[Route('/movie/{id}/video', name: 'app_movie_video')]
    public function movieVideo(int $id): JsonResponse
    {
        $teaser = $this->theMovieDB->teaser($id);
        if (!$teaser instanceof Video) {
            throw new NotFoundHttpException();
        }
        return $this->json($teaser);
    }

    private function renderMoviesPage(string $h1, array $movies, ?Genre $genre = null, ?string $query = null): Response
    {
        $topRatedMovie = array_shift($movies);
        $topRatedMovieTeaser = $topRatedMovie ? $this->theMovieDB->teaser($topRatedMovie->id) : null;

        if (!$topRatedMovieTeaser && $topRatedMovie) {
            array_unshift($movies, $topRatedMovie);
        }

        return $this->render('base.html.twig', [
            'h1' => $h1,
            'genres' => $this->genres,
            'movies' => $movies,
            'topRatedMovie' => $topRatedMovie,
            'topRatedMovieTeaser' => $topRatedMovieTeaser,
            'genre' => $genre,
            'query' => $query,
        ]);
    }
}