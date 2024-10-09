<?php

namespace App\Controller;

use App\Http\Model\Genre;
use App\Message\GetGenreContentMessage;
use App\MessageHandler\AppHandleTrait;
use App\ValueResolver\GenreValueResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/genre/{id}/movies', name: 'app_movies_by_genre')]
class GetGenreController extends AbstractController
{
    use AppHandleTrait;

    public function __construct(MessageBusInterface $messageBus) {
        $this->messageBus = $messageBus;
    }

    public function __invoke(
        #[MapQueryParameter(resolver: GenreValueResolver::class)]
        Genre $genre
    ): Response {
        $result = $this->handleMessage(new GetGenreContentMessage($genre));

        return $this->render('base.html.twig', $result->getContent());
    }
}
