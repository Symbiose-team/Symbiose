<?php

namespace App\Controller;

use App\Entity\Lobby;
use App\Entity\Party;
use App\Form\PartyType;
use App\Repository\PartyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PartyController extends AbstractController
{
    /**
     * @Route("/party", name="party_index", methods={"GET"})
     */
    public function index(PartyRepository $partyRepository): Response
    {
        return $this->render('party/index.html.twig', [
            'parties' => $partyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/party/new", name="party_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $party = new Party();
        $form = $this->createForm(PartyType::class, $party);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($party);
            $entityManager->flush();

            return $this->redirectToRoute('party_index');
        }

        return $this->render('party/new.html.twig', [
            'party' => $party,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/party/afficher/{id}", name="party_show", methods={"GET"})
     */
    public function show(Party $party): Response
    {
        return $this->render('party/show.html.twig', [
            'party' => $party,
        ]);
    }

    /**
     * @Route("/party/edit/{id}", name="party_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Party $party): Response
    {
        $form = $this->createForm(PartyType::class, $party);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('party_index');
        }

        return $this->render('party/edit.html.twig', [
            'party' => $party,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/party/delete/{id}", name="party_delete")
     */
    public function delete(Party $party): Response
    {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($party);
            $entityManager->flush();
        

        return $this->redirectToRoute('party_index');
    }

}
