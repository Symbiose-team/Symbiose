<?php

namespace App\Controller;

use App\Form\GameType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\GameRepository;
use App\Entity\Game;
use App\Entity\User;
use App\Repository\UserRepository;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use Symfony\Component\HttpFoundation\Request;

class GameController extends AbstractController
{
    /**
     * @Route("/game", name="game_index")
     */
    public function index(GameRepository $gameRepository): Response
    {
        return $this->render('game/index.html.twig', [
            'games' => $gameRepository->findAll(),
        ]);
    }
    /**
     * @Route("/game/add", name="game_add", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $game = new Game();
        $game->setTime(new \DateTime());
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($game);
            $entityManager->flush();

            return $this->redirectToRoute('game_index');
        }

        return $this->render('game/add.html.twig', [
            'game' => $game,
            'form' => $form->createView(),
        ]);
    }

}
