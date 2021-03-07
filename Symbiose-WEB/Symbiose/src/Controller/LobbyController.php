<?php

namespace App\Controller;

use App\Entity\Lobby;
use App\Form\Lobby1Type;
use App\Repository\LobbyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class LobbyController extends AbstractController
{
    /**
     * @Route("/lobby", name="lobby_index")
     */
    public function index(LobbyRepository $lobbyRepository): Response
    {
        return $this->render('lobby/index.html.twig', [
            'lobbies' => $lobbyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/lobby/new", name="lobby_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $lobby = new Lobby();
        $form = $this->createForm(Lobby1Type::class, $lobby);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lobby);
            $entityManager->flush();

            return $this->redirectToRoute('lobby_index');
        }

        return $this->render('lobby/new.html.twig', [
            'lobby' => $lobby,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/lobby/afficher/{id}", name="lobby_show", methods={"GET"})
     */
    public function show(Lobby $lobby): Response
    {
        return $this->render('lobby/show.html.twig', [
            'lobby' => $lobby,
        ]);
    }

    /**
     * @Route("/lobby/edit/{id}", name="lobby_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Lobby $lobby): Response
    {
        $form = $this->createForm(Lobby1Type::class, $lobby);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lobby_index');
        }

        return $this->render('lobby/edit.html.twig', [
            'lobby' => $lobby,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/lobby/delete/{id}/", name="lobby_delete", methods={"POST"})
     */
    public function delete(Request $request, Lobby $lobby): Response
    {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lobby);
            $entityManager->flush();


        return $this->redirectToRoute('lobby_index');
    }
}
