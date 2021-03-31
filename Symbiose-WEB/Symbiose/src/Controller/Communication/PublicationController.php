<?php

namespace App\Controller\Communication;

use App\Entity\User;
use App\Entity\Publication;
use App\Form\RegistrationFormType;
use App\Security\UserAuthAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Repository\Communication\PublicationRepository;

class PublicationController extends AbstractController
{
    /**
     * @Route("/newvote", name="addvote")
     */
    public function addvote(PublicationRepository $PublicationRepository,Request $request): Response
    {
        $pub = $PublicationRepository->find($request->query->get('id'));
        $vote = $request->query->get('rating') ;
        $rating =($pub->getVote()+$vote)/2;
        $pub->setVote($rating);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($pub);
        $entityManager->flush();
        return $this->redirectToRoute('publication');

        
    }
    /**
     * @Route("/publication", name="publication")
     */
    public function index(PublicationRepository $PublicationRepository): Response
    {
        return $this->render('/Communication/publication/index.html.twig', [
            'Publications' => $PublicationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/publication", name="admin_publication")
     */
    public function admin(PublicationRepository $PublicationRepository): Response
    {
        return $this->render('/Communication/publication/indexadmin.html.twig', [
            'Publications' => $PublicationRepository->findAll(),
        ]);
    }
    
}
