<?php

namespace App\Controller;

use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventSupplierController extends AbstractController
{
    /**
     * @Route("/event/supplier", name="event_supplier")
     */
    public function index(): Response
    {
        return $this->render('event_supplier/event-event-welcome.html.twig', [
            'controller_name' => 'EventSupplierController',
        ]);
    }

    //TODO Show only events related to the logged in supplier (Select from events where Supplier = "Connected_USER")
    /**
     * @Route("/eventsupplier", name="event_supplier")
     */
    public function supplier_events(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Event::class);


        // look for multiple Product objects matching the supplier
        $events = $repository->findBy(
            ['Supplier' => 'Mahdi']
        );

        //$events=$this->getDoctrine()->getRepository(Event::class)->findAll();

        return $this->render('event_supplier/supplier_event.html.twig', array('events' => $events));
    }

    //Show event by id
    /**
     * @Route("/supplierevent/{id}",name="supplier_event_show")
     */
    public function supplierShow($id){
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);
        return $this->render('event_supplier/show_supplier_event.html.twig',array('event' => $event));
    }

}
