<?php

namespace App\Controller;

use App\Message\VideoMessage;
use App\MessageHandler\AppHandleTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/movie/{id}/video', name: 'app_movie_video')]
class VideoController extends AbstractController
{
    use AppHandleTrait;

    public function __construct(MessageBusInterface $messageBus) {
        $this->messageBus = $messageBus;
    }

    public function __invoke(int $id): JsonResponse
    {
        $result = $this->handleMessage(new VideoMessage($id));
        $video = $result->getContent();

        return $this->json(reset($video));
    }
}
