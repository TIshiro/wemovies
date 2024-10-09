<?php

namespace App\Controller;

use App\Message\AutocompleteMessage;
use App\MessageHandler\AppHandleTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/autocomplete', name: 'app_autocomplete')]
class AutocompleteController extends AbstractController
{
    use AppHandleTrait;

    public function __construct(MessageBusInterface $messageBus) {
        $this->messageBus = $messageBus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $query = $request->query->get('q');
        $result = $this->handleMessage(new AutocompleteMessage($query));

        return $this->json($result->getContent());
    }
}
