<?php

namespace App\Controller\Event;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventWelcomeController extends AbstractController
{
    /**
     * @Route("/event-welcome", name="event-welcome")
     */
    public function index(): Response
    {
        return $this->render('Event/event-welcome/event-welcome.html.twig', [
            'controller_name' => 'EventWelcomeController',
        ]);
    }
}
