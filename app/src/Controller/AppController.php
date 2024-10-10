<?php

namespace App\Controller;

use App\Http\Model\Movie;
use App\Http\TheMovieDB;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    public function __construct(private readonly TheMovieDB $theMovieDB)
    {
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
}