<?php

namespace App\Controller\Communication;

use App\Entity\User;
use App\Entity\Commentaire;
use App\Entity\Publication;

use App\Form\RegistrationFormType;
use App\Repository\Communication\MessageRepository;
use App\Controller\GuardAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Repository\Communication\CommentaireRepository;
use App\Repository\Communication\PublicationRepository;
use symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Message;



class CMobileController extends AbstractController
{

    /**
     * @Route("/Addpub/{contenu}/", name="Addpublication")
     */
    public function insertpub (Request $request,$contenu ) :Response
    {
        $conn = $this->getDoctrine()->getManager()
            ->getConnection();
        $RAW_QUERY="insert into publication (contenu) values ('$contenu') ";
        $statement=  $conn-> prepare ($RAW_QUERY);
        $statement->execute();
        $serializer = new \Symfony\Component\Serializer\Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        return new JsonResponse("added");

    }
    /**
     * @Route("/deletemessage", name="deletemessage", methods={"GET"})
     */
    public function deleteMessage(Request $request,MessageRepository $MessageRepository): Response
    {
        $user = $MessageRepository->find($request->query->get('id'));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();
        $r = new Response($request->query->get('id'));
        return $r;

    }
    /**
     * @Route("/removePublication/{id}/", name="removePublication")
     */
    public function removePub($id)
    {
        $conn = $this->getDoctrine()->getManager()
            ->getConnection();
        $RAW_QUERY="Delete FROM publication WHERE id='$id' ";
        $statement=  $conn-> prepare ($RAW_QUERY);
        $statement->execute();
        $serializer = new Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        return new JsonResponse("deleted");

    }

    /**
     * @Route("/removeCommentMobile/{id}/", name="removeCommentMobile")
     */
    public function removeComment($id)
    {
        $conn = $this->getDoctrine()->getManager()
            ->getConnection();
        $RAW_QUERY="Delete FROM commentaire WHERE id='$id' ";
        $statement=  $conn-> prepare ($RAW_QUERY);
        $statement->execute();
        $serializer = new Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        return new JsonResponse("deleted");

    }
    /**
     * @Route("/updateCommentaireM/{id}/{contenu}", name="updateCommentaireM")
     */
    public function updateCommentaire(Request $request,$contenu ,$id) :Response
    {
        $conn = $this->getDoctrine()->getManager()
            ->getConnection();
        $RAW_QUERY="UPDATE commentaire SET contenu='$contenu'  WHERE id='$id' ";
        $statement=  $conn-> prepare ($RAW_QUERY);
        $statement->execute();
        $serializer = new Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        return new JsonResponse("updated");

    }

    /**
     * @Route("/GetPub")
     */
    public function index(Request $request): Response
    {
        $conn = $this->getDoctrine()->getManager()
            ->getConnection();
        $RAW_QUERY="SELECT * FROM publication ";
        $statement=  $conn-> prepare ($RAW_QUERY);
        $statement->execute();
        $pubs=$statement->fetchAll();
        $serializer = new Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        $formatted = $serializer->normalize(['publications' => $pubs]);
        return new JsonResponse($formatted);

    }
    /**
     * @Route("/affichecomMobileAll/", name="affichecomMobileAll")
     */
    public function indexCom(Request $request): Response
    {
        $conn = $this->getDoctrine()->getManager()
            ->getConnection();
        $RAW_QUERY="SELECT * FROM commentaire ";
        $statement=  $conn-> prepare ($RAW_QUERY);
        $statement->execute();
        $comments=$statement->fetchAll();
        $serializer = new Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        $formatted = $serializer->normalize(['comments' => $comments]);
        return new JsonResponse($formatted);

    }

    /**
     * @Route("/affichecomMobile/{id}/", name="affichecomMobile")
     */
    public function indexC(Request $request , $id): Response
    {
        $conn = $this->getDoctrine()->getManager()
            ->getConnection();
        $RAW_QUERY="SELECT * FROM commentaire WHERE publication_id='$id' ";
        $statement=  $conn-> prepare ($RAW_QUERY);
        $statement->execute();
        $comments=$statement->fetchAll();
        $serializer = new Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        $formatted = $serializer->normalize(['comments' => $comments]);
        return new JsonResponse($formatted);

    }
    /**
     * @Route("/AddComment/{contenu}/{user_id}/{publication_id}", name="AddComment")
     */
    public function insertProduct(Request $request,$contenu,$user_id,$publication_id ) :Response
    {
        $conn = $this->getDoctrine()->getManager()
            ->getConnection();
        $RAW_QUERY="insert into Commentaire (contenu,user_id,publication_id)values('$contenu',$user_id,$publication_id) ";
        $statement=  $conn-> prepare ($RAW_QUERY);
        $statement->execute();
        $serializer = new \Symfony\Component\Serializer\Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        return new JsonResponse("added");

    }
    /**
     * @Route("/AddConversation/{user1_id}/{user2_id}", name="AddConversation")
     */
    public function insertConversation (Request $request,$user1_id,$user2_id ) :Response
    {
        $conn = $this->getDoctrine()->getManager()
            ->getConnection();
        $RAW_QUERY="insert into Conversation (user1_id,user2_id)values($user1_id,$user2_id) ";
        $statement=  $conn-> prepare ($RAW_QUERY);
        $statement->execute();
        $serializer = new \Symfony\Component\Serializer\Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        return new JsonResponse("added");

    }
}