<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\SpecialEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class EventController extends AbstractController
{
    //Get event list
    /**
     * @Route("/events", name="event_list")
     * @Method({"GET"})
     */
    public function index(): Response
    {

        //TODO add all the events in one list (Events and Special events)
        $events=$this->getDoctrine()->getRepository(Event::class)->findAll();
        $Sevents=$this->getDoctrine()->getRepository(SpecialEvent::class)->findAll();
        return $this->render('event/event.html.twig', array(
            'events' => $events, 'SpecialEvents'=> $Sevents));
    }

    //TODO Work on the logic (as a client i want to join an event)
    /**
     * @Route("/event/join/{id}", name="join_event")
     */
    public function join_event(): Response
    {
        return $this->render('/event/join_event.html.twig');
    }

    //TODO Work on the logic (as a client i want to join an event)
    /**
     * @Route("/specialevent/join/{id}", name="join_special_event")
     */
    public function join_specialevent(): Response
    {
        return $this->render('/event/join_special_event.html.twig');
    }

    //Order matters!
    //Show event by id
    /**
     * @Route("/event/{id}",name="event_show")
     */
    public function show($id){
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);
        return $this->render('event/show_event.html.twig',array('event' => $event));
    }


}
