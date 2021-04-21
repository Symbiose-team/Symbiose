<?php

namespace App\Controller\Event;

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
use function Sodium\compare;

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
     * @Route("/admin/event", name="event_adminV2")
     */
    public function event_admin(PaginatorInterface $paginator, Request $request): Response
    {

        $count_events= $this->em->createQuery('SELECT COUNT(e) from App\Entity\Event e')->getSingleScalarResult();
        $count_sevents= $this->em->createQuery('SELECT COUNT(e) from App\Entity\SpecialEvent e')->getSingleScalarResult();

        //event pagination
        $events = $paginator->paginate(
            $this->event_repository->status_true(),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('Event/event_admin/eventadmin.html.twig', [
            'current_menu' => 'events',
            'events' => $events,
            'count_ev' => $count_events,
            'count_sev' => $count_sevents
        ]);

    }

    //dashboard : special event
    /**
     * @Route("/admin/Sevent", name="sevent_admin")
     */
    public function sevent_admin(PaginatorInterface $paginator, Request $request): Response
    {

        $Sevents = $paginator->paginate(
            $this->sevent_repository->findAll(),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('Event/event_admin/eventadmin_sevent.html.twig', ['current_menu' => 'Sevents', 'Sevents' => $Sevents]);

    }

    //dashboard : invalid events
    /**
     * @Route("/admin/invalidevents", name="invalid_event")
     */
    public function invalid_event(PaginatorInterface $paginator, Request $request): Response
    {
        $output = $paginator->paginate(
            $this->event_repository->status_false(),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('Event/event_admin/invalid_event.html.twig', ['current_menu' => 'events',
            'events' => $output ]);

    }

    //verify event
    /**
     * @Route("/admin/invalidevents/verify/{id}", name="verify_event")
     */
    public function verify_event($id): Response
    {

        $event = $this->event_repository->find($id);
        $event-> setState(1);
        $this->em->flush();
        dump($event);

        return $this->redirectToRoute('invalid_event');
    }

    //cancel event
    /**
     * @Route("/admin/event/cancel/{id}", name="cancel_event")
     */
    public function cancel_event($id): Response
    {

        $event = $this->event_repository->find($id);
        $event-> setState(0);
        $this->em->flush();
        dump($event);

        return $this->redirectToRoute('event_adminV2');
    }

    //Add an event
    /**
     * @Route("/admin/event/add", name="add_event")
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

            return $this->redirectToRoute('event_adminV2');
        }

        return $this->render('Event/event_admin/new_event.html.twig', array('form'=>$form->createView()));
    }

    //Edit an event
    /**
     * @Route("/admin/event/edit/{id}", name="edit_event")
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

            return $this->redirectToRoute('event_adminV2');
        }

        return $this->render('Event/event_admin/edit_event.html.twig', array('form'=>$form->createView()));
    }

    //DELETE event
    /**
     * @Route ("/admin/event/delete/{id}", name="delete_event")
     * @Method ({"DELETE"})
     */
    public function delete(Request $request, $id){
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($event);
        $entityManager->flush();
        return $this->redirectToRoute('event_adminV2');

    }

    //Add a Special event as an admin
    /**
     * @Route("/admin/sevent/add", name="add_sevent")
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

        return $this->render('Event/event_admin/new_special_event.html.twig', array('form'=>$form->createView()));
    }

    //Edit a Special event
    /**
     * @Route("/admin/sevent/edit/{id}", name="edit_sevent")
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

        return $this->render('Event/event_admin/edit_special_event.html.twig', array('form'=>$form->createView()));
    }

    //DELETE Special event
    /**
     * @Route ("/admin/sevent/delete/{id}", name="delete_sevent")
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
     * @Route("/admin/event/{id}",name="eventadmin_show")
     */
    public function show($id){
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);
        return $this->render('Event/event_admin/show_admin_event.html.twig',array('event' => $event));
    }

    //Show Special event by id
    /**
     * @Route("/admin/seventadmin/sevent/{id}",name="seventadmin_show")
     */
    public function showSevent($id){
        $Sevent = $this->getDoctrine()->getRepository(SpecialEvent::class)->find($id);
        return $this->render('Event/event_admin/show_special_event.html.twig',array('Sevent' => $Sevent));
    }
}
