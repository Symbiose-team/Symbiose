<?php

namespace App\Controller;

use App\Entity\Event;
//TODO : FIX @METHOD annotations 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    /**
     * @Route("/event", name="event_list")
     * @Method({"GET"})
     */
    public function index(): Response
    {

        $events=$this->getDoctrine()->getRepository(Event::class)->findAll();

        return $this->render('event/event.html.twig', array('events' => $events));
    }

    /**
     * @Route("/event/{id}",name="event_show")
     */
    public function show($id){
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);
        return $this->render('event/show_event.html.twig',array('event' => $event));
    }
}
