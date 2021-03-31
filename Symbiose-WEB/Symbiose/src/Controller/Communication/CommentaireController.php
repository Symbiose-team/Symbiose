<?php

namespace App\Controller\Communication;

use App\Entity\User;
use App\Entity\Commentaire;
use App\Entity\Publication;

use App\Form\RegistrationFormType;
use App\Security\UserAuthAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Repository\Communication\CommentaireRepository;
use App\Repository\Communication\PublicationRepository;


class CommentaireController extends AbstractController
{
    /**
     * @Route("/addCommentaire", name="addCommentaire")
     */
    public function add(Request $request,PublicationRepository $PublicationRepository,CommentaireRepository $CommentaireRepository)
    {



        $id = $request->get('id');
        $contenu = $request->get('contenu');

         $pub =  $PublicationRepository->find($id);
         $user = $this->getUser();

        $commentaire = new Commentaire();
        $commentaire->setUser($user);
        $commentaire->setContenu($contenu);
        $commentaire->setPublication($pub);
        $commentaire->setDate(new \DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($commentaire);
        $entityManager->flush();
        return $this->redirect($this->generateUrl('publication'));


    }
        /**
     * @Route("/removeCommentaire", name="removeCommentaire")
     */
    public function removeCommentaire(Request $request,PublicationRepository $PublicationRepository,CommentaireRepository $CommentaireRepository)
    {
        $id = $request->get('id');

         $commentaire =  $CommentaireRepository->find($id);
         $entityManager = $this->getDoctrine()->getManager();
         $entityManager->remove($commentaire);
         $entityManager->flush();
         return $this->redirect($this->generateUrl('publication'));

    }
    /**
     * @Route("/removeComment", name="removeComment")
     */
    public function removeComment(Request $request,PublicationRepository $PublicationRepository,CommentaireRepository $CommentaireRepository)
    {
        $id = $request->get('id');

        $commentaire =  $CommentaireRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($commentaire);
        $entityManager->flush();
        return $this->redirect($this->generateUrl('admin'));

    }
        /**
     * @Route("/updateCommentaire", name="updateCommentaire")
     */
    public function updateCommentaire(Request $request,PublicationRepository $PublicationRepository,CommentaireRepository $CommentaireRepository)
    {
         $id = $request->get('id');
         $contenu = $request->get('contenu');
         $commentaire =  $CommentaireRepository->find($id);
         $commentaire->setContenu($contenu);
         $commentaire->setDate(new \DateTime());
         $entityManager = $this->getDoctrine()->getManager();
         $entityManager->persist($commentaire);
         $entityManager->flush();
         return $this->redirect($this->generateUrl('admin'));

    }
    
}
