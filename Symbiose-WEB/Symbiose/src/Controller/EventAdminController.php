<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\SpecialEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventAdminController extends AbstractController
{
    /**
     * @Route("/eventadmin", name="event_admin")
     */
    public function admin(): Response
    {
        $S_events=$this->getDoctrine()->getRepository(SpecialEvent::class)->findAll();
        $events=$this->getDoctrine()->getRepository(Event::class)->findAll();

        return $this->render('event_admin/eventadmin.html.twig',array('SpecialEvents' => $S_events,'events' => $events));
    }
}
