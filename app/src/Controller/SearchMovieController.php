<?php

namespace App\Controller;

use App\Message\SearchMovieMessage;
use App\MessageHandler\AppHandleTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/search', name: 'app_search')]
class SearchMovieController extends AbstractController
{
    use AppHandleTrait;

    public function __construct(MessageBusInterface $messageBus) {
        $this->messageBus = $messageBus;
    }

    public function __invoke(Request $request): Response
    {
        $query = $request->query->get('q');
        $result = $this->handleMessage(new SearchMovieMessage($query));

        return $this->render('base.html.twig', $result->getContent());
    }
}
