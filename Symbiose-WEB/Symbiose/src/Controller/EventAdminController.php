<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\SpecialEvent;
use App\Form\EventType;
use App\Form\SpecialEventType;
use App\Repository\EventRepository;
use App\Repository\SpecialEventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventAdminController extends AbstractController
{

    //constructor
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

    //dashboard : event
    /**
     * @Route("/eventadmin", name="event_admin")
     */
    public function event_admin(PaginatorInterface $paginator, Request $request): Response
    {

        //event pagination
        $events = $paginator->paginate(
            $this->event_repository->findAll(),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('event_admin/eventadmin.html.twig', ['current_menu' => 'events', 'events' => $events]);

    }

    //dashboard : special event
    /**
     * @Route("/seventadmin", name="sevent_admin")
     */
    public function sevent_admin(PaginatorInterface $paginator, Request $request): Response
    {

        $Sevents = $paginator->paginate(
            $this->sevent_repository->findAll(),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('event_admin/eventadmin_sevent.html.twig', ['current_menu' => 'Sevents', 'Sevents' => $Sevents]);

    }

    //Add an event
    /**
     * @Route("/event/add", name="add_event")
     * @Method({"GET","POST"})
     */
    public function new(Request $request){
        $event = new Event();

        $form= $this->createForm(EventType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $event = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('event_admin');
        }

        return $this->render('event_admin/new_event.html.twig', array('form'=>$form->createView()));
    }

    //Edit an event
    /**
     * @Route("/event/edit/{id}", name="edit_event")
     * @Method({"GET","POST"})
     */
    public function edit(Request $request, $id){
        $event = new Event();
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);

        $form= $this->createForm(EventType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('event_admin');
        }

        return $this->render('event_admin/edit_event.html.twig', array('form'=>$form->createView()));
    }

    //DELETE event
    /**
     * @Route ("/event/delete/{id}", name="delete_event")
     * @Method ({"DELETE"})
     */
    public function delete(Request $request, $id){
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($event);
        $entityManager->flush();
        return $this->redirectToRoute('event_admin');

    }

    //Add a Special event as an admin
    /**
     * @Route("/sevent/add", name="add_sevent")
     * @Method({"GET","POST"})
     */
    public function newSevent(Request $request){
        $Sevent = new SpecialEvent();

        $form= $this->createForm(SpecialEventType::class, $Sevent);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $Sevent = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Sevent);
            $entityManager->flush();

            return $this->redirectToRoute('sevent_admin');
        }

        return $this->render('event_admin/new_special_event.html.twig', array('form'=>$form->createView()));
    }

    //Edit a Special event
    /**
     * @Route("/sevent/edit/{id}", name="edit_sevent")
     * @Method({"GET","POST"})
     */
    public function editSevent(Request $request, $id){
        $Sevent = new SpecialEvent();
        $Sevent = $this->getDoctrine()->getRepository(SpecialEvent::class)->find($id);

        $form= $this->createForm(SpecialEventType::class, $Sevent);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('sevent_admin');
        }

        return $this->render('event_admin/edit_special_event.html.twig', array('form'=>$form->createView()));
    }

    //DELETE Special event
    /**
     * @Route ("/sevent/delete/{id}", name="delete_sevent")
     * @Method ({"DELETE"})
     */
    public function deleteSevent(Request $request, $id){
        $Sevent = $this->getDoctrine()->getRepository(SpecialEvent::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($Sevent);
        $entityManager->flush();
        return $this->redirectToRoute('sevent_admin');
    }

    //Order matters!
    //Show admin event by id
    /**
     * @Route("/eventadmin/event/{id}",name="eventadmin_show")
     */
    public function show($id){
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);
        return $this->render('event_admin/show_admin_event.html.twig',array('event' => $event));
    }

    //Show Special event by id
    /**
     * @Route("seventadmin/sevent/{id}",name="seventadmin_show")
     */
    public function showSevent($id){
        $Sevent = $this->getDoctrine()->getRepository(SpecialEvent::class)->find($id);
        return $this->render('event_admin/show_special_event.html.twig',array('Sevent' => $Sevent));
    }
}
