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
    public function __construct(private readonly TheMovieDB $theMovieDB)
    {
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $topRatedMovies = $this->theMovieDB->topRatedMovies();
        $topRatedMovie = array_shift($topRatedMovies);
        return $this->render(
            'base.html.twig',
            [
                'h1' => 'À propos de We Movies',
                'genres' => $this->theMovieDB->genres(),
                'movies' => $topRatedMovies,
                'topRatedMovie' => $topRatedMovie,
                'topRatedMovieTeaser' => $topRatedMovie ? $this->theMovieDB->teaser($topRatedMovie->id) : null,
            ]
        );
    }

    #[Route('/genre/{id}/movies', name: 'app_movies_by_genre')]
    public function moviesByGenre(int $id): Response
    {
        $genre = $this->theMovieDB->genre($id);
        if (!$genre instanceof Genre) {
           throw new NotFoundHttpException();
        }
        $movies = $this->theMovieDB->moviesByGenre($id);
        $topRatedMovie = array_shift($movies);
        return $this->render(
            'base.html.twig',
            [
                'h1' => 'We movies: ' . ucfirst($genre->name),
                'genre' => $genre,
                'genres' => $this->theMovieDB->genres(),
                'movies' => $movies,
                'topRatedMovie' => $topRatedMovie,
                'topRatedMovieTeaser' => $topRatedMovie ? $this->theMovieDB->teaser($topRatedMovie->id) : null,
            ]
        );
    }

    #[Route('/search', name: 'app_search')]
    public function search(Request $request): Response
    {
        $query  = $request->query->get('q');
        return $this->render(
            'base.html.twig',
            [
                'h1' => 'We movies: Result for ' . $query,
                'query' => $query,
                'genres' => $this->theMovieDB->genres(),
                'movies' => $this->theMovieDB->movies($query),
            ]
        );
    }

    #[Route('/autocomplete', name: 'app_autocomplete')]
    public function autocomplete(Request $request): JsonResponse
    {
        $query  = $request->query->get('q');
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
}
