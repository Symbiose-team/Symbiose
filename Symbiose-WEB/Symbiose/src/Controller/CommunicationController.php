<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommunicationController extends AbstractController
{
    /**
     * @Route("/communication", name="communication")
     */
    public function index(): Response
    {
        return $this->render('communication/index.html.twig', [
            'controller_name' => 'CommunicationController',
        ]);
    }

    /**
     * @Route("/chat",name="tchat")
     */
    public function chat(){
        return $this->render('communication/chat.html.twig');
    }
    /**
     * @Route("/claim",name="claim")
     */
    public function claim(){
        return $this->render('communication/claim.html.twig');
    }
    /**
     * @Route("/comment",name="comment")
     */
    public function comment(){
        return $this->render('communication/comment.html.twig');
    }
    /**
     * @Route("/clientt",name="client")
     */
    public function clientt(){
        return $this->render('communication/clientt.html.twig');
    }
    /**
     * @Route("/admin",name="admin")
     */
    public function admin(){
        return $this->render('communication/admin.html.twig');
    }
    /**
     * @Route("/supplier",name="supplier")
     */
    public function supplier(){
        return $this->render('communication/supplier.html.twig');
    }
}
