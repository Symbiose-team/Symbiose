<?php

namespace App\Controller\Communication;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\Communication\MessageRepository;
use App\Controller\GuardAuthenticator;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Repository\Communication\PublicationRepository;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class PMobileController extends AbstractController
{

    /**
     * @Route("/affichemsgMobile/{conversation_id}/", name="affichemsgMobile")
     */
    public function indexC(Request $request , $conversation_id): Response
    {
        $conn = $this->getDoctrine()->getManager()
            ->getConnection();
        $RAW_QUERY="SELECT * FROM message WHERE conversation_id='$conversation_id' ";
        $statement=  $conn-> prepare ($RAW_QUERY);
        $statement->execute();
        $comments=$statement->fetchAll();
        $serializer = new \Symfony\Component\Serializer\Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        $formatted = $serializer->normalize(['comments' => $comments]);
        return new JsonResponse($formatted);

    }
    /**
     * @Route("/AjoutMessageM/{conversation_id}/{user_id}/{contenu}", name="ajoutMessageM")
     */
    public function updateMessage(Request $request,$contenu ,$conversation_id ,$user_id) :Response
    {
        $conn = $this->getDoctrine()->getManager()
            ->getConnection();
        $RAW_QUERY="insert into message (contenu,conversation_id,user_id) values ('$contenu',$conversation_id,$user_id) ";
        $statement=  $conn-> prepare ($RAW_QUERY);
        $statement->execute();
        $serializer = new \Symfony\Component\Serializer\Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        return new JsonResponse("added");

    }

    /**
     * @Route("/deletemessageM/{id}/", name="deletemessageM", methods={"GET"})
     */
    public function deleteMessage(Request $request,$id): Response
    {
        $conn = $this->getDoctrine()->getManager()
            ->getConnection();
        $RAW_QUERY="Delete FROM message WHERE id='$id' ";
        $statement=  $conn-> prepare ($RAW_QUERY);
        $statement->execute();
        $serializer = new \Symfony\Component\Serializer\Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        return new JsonResponse("deleted");

    }
    /**
     * @Route("/GetConv")
     */
    public function index(Request $request): Response
    {
        $conn = $this->getDoctrine()->getManager()
            ->getConnection();
        $RAW_QUERY="SELECT c.*,u.email FROM conversation c , user u WHERE c.user2_id=u.id ";
        $statement=  $conn-> prepare ($RAW_QUERY);
        $statement->execute();
        $pubs=$statement->fetchAll();
        $serializer = new \Symfony\Component\Serializer\Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        $formatted = $serializer->normalize(['conversations' => $pubs]);
        return new JsonResponse($formatted);

    }
    /**
     * @Route("/Getname/{id}/")
     */
    public function GetName(Request $request,$id): Response
    {
        $conn = $this->getDoctrine()->getManager()
            ->getConnection();
        $RAW_QUERY="SELECT email FROM user WHERE id='$id' ";
        $statement=  $conn-> prepare ($RAW_QUERY);
        $statement->execute();
        $pubs=$statement->fetchAll();
        $serializer = new \Symfony\Component\Serializer\Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        $formatted = $serializer->normalize(['names' => $pubs]);
        return new JsonResponse($formatted);

    }
    /**
     * @Route("/updateMessageM/{id}/{contenu}", name="updateMessageM")
     */
    public function updateMessageM(Request $request,$contenu ,$id) :Response
    {
        $conn = $this->getDoctrine()->getManager()
            ->getConnection();
        $RAW_QUERY="UPDATE message SET contenu='$contenu'  WHERE id='$id' ";
        $statement=  $conn-> prepare ($RAW_QUERY);
        $statement->execute();
        $serializer = new \Symfony\Component\Serializer\Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        return new JsonResponse("updated");

    }


}