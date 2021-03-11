<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Participant;
use App\Repository\ConversationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use http\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/conversation", name="conversation")
 */

class ConversationController extends AbstractController
{
    /**
     * @var ConversationRepository
     */
    private $conversationRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager,
                                ConversationRepository $conversationRepository)
    {
        $this->userRepository=$userRepository;
        $this->entityManager=$entityManager;

        $this->conversationRepository = $conversationRepository;
    }
    /**
     * @Route("/", name="getconversation")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return  JsonResponse
     * @throws \Exception
     */
    public function index(Request $request): Response
    {
        $otherUser=$request->get(key('otherUser'),0);
        $otherUse=$this->userRepository->find($otherUser);
        if(is_null($otherUser)){
           throw \Exception("user was not found");
        }
        if( $otherUser->getId()===$this->getUser()->getId()){
            throw \Exception("you can not create a conversation with your self");
        }

        $Conversation=$this->conversationRepository->findConversationByParticipants(
            $otherUser->getId(),
            $this->getUser()->getId()
        );

    if (count($Conversation)){
        throw new \Exception("the conversation alerady exist");
    }
    $conversation=new Conversation();


    $participant= new Participant();
    $participant->setUser($this->getUser());
    $participant->setConversation($conversation);

    $otherParticipant= new Participant();
    $otherParticipant->setUser($otherUser);
    $otherParticipant->setConversation($conversation);

    $this->entityManager->getConnection()->beginTransaction();
    try{
        $this->entityManager->persist($conversation);
        $this->entityManager->persist($participant);
        $this->entityManager->persist($otherParticipant);
        $this->entityManager->commit();
        $this->entityManager->flush();
    }catch (\Exception $e){
        $this->entityManager->rollback();
    throw $e;}


        return $this->json(['$id'=>$conversation->getId()],Response::HTTP_CREATED,[],[]);
    }


}
