<?php

namespace App\Controller;

use App\Form\GameType;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\GameRepository;
use App\Entity\Game;
use App\Entity\User;
use App\Repository\UserRepository;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

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
     * @Route("/game/user/{id}", name="game_user")
     * @param User $userWithGames
     * @return Response
     */
    public function userPosts(User $userWithGames, GameRepository $gameRepository)
    {
        return $this->render(
            'game/index.html.twig', [
                'games' => $gameRepository->findBy(
                    ['user' => $userWithGames],
                    ['time' => 'DESC']
                ),
                'user' => $userWithGames
            ]
        );
    }



    /**
     * @Route("/game/add", name="game_add", methods={"GET","POST"})
     */
    public function new(Request $request, TokenStorageInterface $tokenStorage): Response
    {
        $user= $tokenStorage->getToken()->getUser();
        $game = new Game();
        $game->setTime(new \DateTime());
        $game->setUser($user);
      #  $game->setJoinedBy($user);
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


    /**
     * @Route("/game/edit/{id}", name="game_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Game $game): Response
    {
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('game_index');
        }

        return $this->render('game/add.html.twig', [
            'game' => $game,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/game/delete/{id}/", name="game_delete")
     */
    public function delete(Request $request, Game $game): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($game);
        $entityManager->flush();
        $this->addFlash('notice','Lobby was deleted');

        return $this->redirectToRoute('game_index');
    }




    /**
     * @Route("/game/{id}", name="game_show", methods={"GET"})
     */
    public function show(Game $game): Response
    {
        return $this->render('game/show.html.twig', [
            'game' => $game,
        ]);
    }


    /**
     * @Route("/game/search", name="game_search")
     */
    public function searchbyname(Request $request):Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        if ($request->isMethod("POST")){
            $name=$request->get('name');
            $games=$entityManager->getRepository(Game::class)->findBy(array('name'=>$name));
            return $this->render('game/index.html.twig', [
                'games' => $games,
            ]);
        }


    }



}
