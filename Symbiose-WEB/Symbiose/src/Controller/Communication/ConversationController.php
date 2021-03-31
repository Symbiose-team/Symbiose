<?php

namespace App\Controller\Communication;

use App\Entity\Conversation;
use App\Entity\User;

use App\Form\Conversation1Type;
use App\Repository\Communication\ConversationRepository;
use App\Repository\UserRepository;
use App\Repository\Communication\MessageRepository;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Message;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/conversation")
 */
class ConversationController extends AbstractController
{
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
     * @Route("/", name="conversation_index", methods={"GET"})
     */
    public function index(ConversationRepository $conversationRepository): Response
    {
        return $this->render('/Communication/conversation/index.html.twig', [
            'conversations' => $conversationRepository->findAll(),
        ]);
    }

  /**
     * @Route("/refresh", name="refresh", methods={"GET"})
     */
    public function refsh(ConversationRepository $conversationRepository,Request $request): Response
    {
        header('Access-Control-Allow-Origin: *');
        $test1 = $conversationRepository->find($request->query->get('id'));


            $message = array();
            foreach ($test1->getMessages() as $area) {
                $areasArray[] = array(
                    'id' =>$area->getId(),
                    'username' => $area->getUser()->getUsername(),
                    'contenu' => $area->getContenu(),
                    'date' =>$result = $area->getDate()->format('F d,Y H:i')
                    ,

                );
            }
    
    
        
        $response = new JsonResponse([
            'id' => $test1->getId(),
            'user1' => $test1->getUser1()->getUsername(),
            'user2' =>$test1->getUser2()->getUsername(),
            'message' => $areasArray,
        ]);
        
        // Use the JSON_PRETTY_PRINT 
        $response->setEncodingOptions( $response->getEncodingOptions() | JSON_PRETTY_PRINT );
        
        return $response;   
    }
      /**
     * @Route("/newmessage", name="newmessage", methods={"GET","POST"})
     */
    public function newmessage(Request $request,UserRepository $UserRepository,conversationRepository $conversationRepository): Response
    {
            $entityManager = $this->getDoctrine()->getManager();
            $test1 = $conversationRepository->find($request->query->get('id'));
            $Message = new Message();
            $Message->setDate(new \DateTime);
            $Message->setContenu($request->query->get('message'));
            $user = $UserRepository->find($request->query->get('user'));
            $Message->setUser($user);
           
                    $Message->setConversation($test1);
                    $test1->addMessage($Message);
                    $entityManager->persist($Message);
                    $entityManager->flush();
        
    }

    /**
     * @Route("/new", name="conversation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $conversation = new Conversation();
        $form = $this->createForm(Conversation1Type::class, $conversation);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $entityManager = $this->getDoctrine()->getManager();
            $Message = new Message();
            $Message->setDate(new \DateTime);
            $Message->setContenu($request->request->get('message'));
            $Message->setUser($this->getUser());

            $test1 = $this->getDoctrine()->getRepository(Conversation::class)->findOneBy(   
                array('User1' => $this->getUser(),'User2' => $conversation->getUser2()));
            $test2 = $this->getDoctrine()->getRepository(Conversation::class)->findOneBy(   
                ['User2' => $this->getUser(),'User1' => $conversation->getUser2()]);
            if (!($test1) && !($test2)) {
                $conversation->setUser1($this->getUser());
                $Message->setConversation($conversation);
                $entityManager->persist($Message);
                $entityManager->persist($conversation);
                $entityManager->flush();
            }
            else {
                if ($test1) {
                    $Message->setConversation($test1);
                    $test1->addMessage($Message);
                    $entityManager->persist($Message);
                    $entityManager->flush();

                }
                if ($test2) {
                    $Message->setConversation($test2);
                    $test2->addMessage($Message);
                    $entityManager->persist($Message);
                    $entityManager->flush();
                }
                
            }
            
        
           

            return $this->render('/Communication/conversation/show.html.twig', [
                'conversation' => $conversation,
            ]);        }

        return $this->render('/Communication/conversation/new.html.twig', [
            'conversation' => $conversation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="conversation_show", methods={"GET"})
     */
    public function show(Conversation $conversation): Response
    {
        return $this->render('/Communication/conversation/show.html.twig', [
            'conversation' => $conversation,
        ]);
    }
      /**
     * @Route("/show", name="show", methods={"POST"})
     */
    public function sho(Conversation $conversation, Request $request): Response
    {
        $test1 = $this->getDoctrine()->getRepository(Conversation::class)->find();
        
        $response = new JsonResponse([
            'id' => $test1->getId(),
            'user1' => $test1->getUser1()->getUsername(),
            'user2' =>$test1->getUser2()->getUsername(),
            'message' => [
                'username' => $test1->getMessages()->getUser()->getUsername(),
                'contenu' => $test1->getMessages()->getContenu(),
            ]
        ]);
        
        // Use the JSON_PRETTY_PRINT 
     //   $response->setEncodingOptions( $response->getEncodingOptions() | JSON_PRETTY_PRINT );
        
        return $response;   

    }

    /**
     * @Route("/{id}/edit", name="conversation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Conversation $conversation): Response
    {
        $form = $this->createForm(Conversation1Type::class, $conversation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('conversation_index');
        }

        return $this->render('/Communication/conversation/edit.html.twig', [
            'conversation' => $conversation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="conversation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Conversation $conversation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$conversation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($conversation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('conversation_index');
    }

}
