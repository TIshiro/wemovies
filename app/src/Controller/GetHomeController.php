<?php

namespace App\Controller;

use App\Message\GetHomeContentMessage;
use App\MessageHandler\AppHandleTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'app_home')]
class GetHomeController extends AbstractController
{
    use AppHandleTrait;

    public function __construct(MessageBusInterface $messageBus) {
        $this->messageBus = $messageBus;
    }

    public function __invoke(): Response
    {
        $result = $this->handleMessage(new GetHomeContentMessage());

        return $this->render('base.html.twig', $result->getContent());
    }
}
