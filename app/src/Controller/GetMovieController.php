<?php

namespace App\Controller;

use App\Http\Model\Movie;
use App\ValueResolver\MovieValueResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/movie/{id}', name: 'app_movie')]
class GetMovieController extends AbstractController
{
    public function __invoke(
        #[MapQueryParameter(resolver: MovieValueResolver::class)]
        Movie $movie
    ): JsonResponse {
        return $this->json($movie);
    }
}
