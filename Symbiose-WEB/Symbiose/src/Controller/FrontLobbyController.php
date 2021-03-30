<?php

namespace App\Controller;

namespace App\Controller;

use App\Entity\Lobby;
use App\Entity\User;
use App\Form\Lobby1Type;
use App\Form\UserjoinType;
use App\Repository\LobbyRepository;
use App\Repository\UserRepository;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class FrontLobbyController extends AbstractController
{
    /**
     * @Route("/front/lobby", name="front_lobby")
     */
    public function index(LobbyRepository $lobbyRepository): Response
    {
        $lobbyRepository = $this->getDoctrine()->getRepository(Lobby::class)->findBy([], ['name' => 'DESC']);
        return $this->render('front_lobby/index.html.twig', [
            'lobbies' => $lobbyRepository,
        ]);
    }

    /**
     * @Route("/front/lobby/new", name="front_lobby_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $lobby = new Lobby();
        $form = $this->createForm(Lobby1Type::class, $lobby);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lobby);
            $entityManager->flush();

            return $this->redirectToRoute('front_lobby');
        }

        return $this->render('front_lobby/new.html.twig', [
            'lobby' => $lobby,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("front/lobby/delete/{id}/", name="front_lobby_delete", methods={"GET"})
     */
    public function delete(Request $request, Lobby $lobby): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($lobby);
        $entityManager->flush();


        return $this->redirectToRoute('front_lobby');
    }







    /**
     * @Route("/lobby/comming_soon", name="comming_soon")
     */
    public function commingsoon(): Response
    {
        return $this->render('front_lobby/comming_soon.html.twig');
    }


}
