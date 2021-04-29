<?php

namespace App\Controller\Event;

use App\Entity\Event;
use App\Repository\EventRepository;
use App\Repository\SpecialEventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Form\SupplierType;
use App\Form\EventType;

class EventSupplierController extends AbstractController
{

    private $event_repository;
    private $sevent_repository;

    /**
     * $var ObjectManager
     */
    private $em;

    public function __construct(EventRepository $event_repository,
                                SpecialEventRepository $sevent_repository,
                                EntityManagerInterface $em)
    {
        $this->event_repository = $event_repository;
        $this->sevent_repository = $sevent_repository;
        $this->em = $em;
    }

    //TODO Show only events related to the logged in supplier (Select from events where Supplier = "Connected_USER")
    /**
     * @Route("/eventsupplier", name="event_supplier")
     * @Method({"GET"})
     */
    public function supplier_events(): Response
    {
        //TODO based on username of logged in user should be dynamic

        $name = 'Mahdi';

        $events = $this->event_repository->find_by_user($name);

        return $this->render('Event/event_supplier/supplier_event.html.twig', array('events' => $events));
    }

    //Add an event
    /**
     * @Route("/eventsupplier/add", name="add_supplier_event")
     * @Method({"GET","POST"})
     */
    public function new(Request $request){
        $event = new Event();
        $name = 'Mahdi';

        $form= $this->createForm(SupplierType::class, $event);
        $event->setState(0);
        $event->setSupplier($name);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()){

            $event = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('event_supplier');
        }
        return $this->render('Event/event_supplier/new_event.html.twig', array('form'=>$form->createView()));
    }

    //Show event by id
    /**
     * @Route("/supplierevent/{id}",name="supplier_event_show")
     */
    public function supplierShow($id){
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);
        return $this->render('Event/event_supplier/show_supplier_event.html.twig',array('event' => $event));
    }

}
