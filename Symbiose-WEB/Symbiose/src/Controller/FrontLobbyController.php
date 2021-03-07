<?php

namespace App\Controller;

use App\Repository\LobbyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontLobbyController extends AbstractController
{
    /**
     * @Route("/front/lobby", name="front_lobby")
     */
    public function index(LobbyRepository $lobbyRepository): Response
    {
        return $this->render('front_lobby/index.html.twig', [
            'lobbies' => $lobbyRepository->findAll(),
        ]);
    }
    /**
     * @Route("/lobby/comming_soon", name="comming_soon")
     */
    public function commingsoon(): Response
    {
        return $this->render('front_lobby/comming_soon.html.twig');
    }


}
