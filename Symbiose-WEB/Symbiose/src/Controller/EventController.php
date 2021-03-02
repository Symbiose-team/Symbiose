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
     * @Route("/clientevent", name="event_list")
     * @Method({"GET"})
     */
    public function index(): Response
    {

        $events=$this->getDoctrine()->getRepository(Event::class)->findAll();

        return $this->render('event/event.html.twig', array('events' => $events));
    }

    //Add an event
    /**
     * @Route("/event/add", name="new_event")
     * @Method({"GET","POST"})
     */
    public function new(Request $request){
        $event = new Event();

        $form= $this->createFormBuilder($event)
            ->add('Name',TextType::class,array('attr' => array('class'=> 'form-control')))
            ->add('Supplier',TextType::class,array(//'required'=>false,
                'attr' => array('class'=>'form-control')))
            ->add('NumParticipants',NumberType::class,array('attr' => array('class'=>'form-control')))
            ->add('NumRemaining',NumberType::class,array('attr' => array('class'=>'form-control')))
            ->add('Type',TextType::class,array('attr' => array('class'=>'form-control')))
            ->add('Date',DateType::class,array('attr' => array('class'=>'form-control')))
            ->add('save',SubmitType::class, array('label'=>'Create',
                'attr'=>array('class'=>'btn btn-primary mt-3')))

            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $event = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('event_list');
        }

        return $this->render('event/new_event.html.twig', array('form'=>$form->createView()));
    }

    /**
     * @Route("/event/edit/{id}", name="edit_event")
     * @Method({"GET","POST"})
     */
    public function edit(Request $request, $id){
        $event = new Event();
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);

        $form= $this->createFormBuilder($event)
            ->add('Name',TextType::class,array('attr' => array('class'=> 'form-control')))
            ->add('Supplier',TextType::class,array(//'required'=>false,
                'attr' => array('class'=>'form-control')))
            ->add('NumParticipants',NumberType::class,array('attr' => array('class'=>'form-control')))
            ->add('NumRemaining',NumberType::class,array('attr' => array('class'=>'form-control')))
            ->add('Type',TextType::class,array('attr' => array('class'=>'form-control')))
            ->add('Date',DateType::class,array('attr' => array('class'=>'form-control')))
            ->add('save',SubmitType::class, array('label'=>'Create',
                'attr'=>array('class'=>'btn btn-primary mt-3')))

            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('event_list');
        }

        return $this->render('event/edit_event.html.twig', array('form'=>$form->createView()));
    }

    /**
     * @Route("/eventsupplier", name="event_supplier")
     */
    public function supplier_events(): Response
    {

        $events=$this->getDoctrine()->getRepository(Event::class)->findAll();

        return $this->render('event_supplier/supplier_event.html.twig', array('events' => $events));
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

    //TODO Figure this out
    //DELETE event
    /**
     * @Route ("/event/delete/{id}")
     * @Method ({"DELETE"})
     */
    public function delete(Request $request, $id){
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($event);
        $entityManager->flush();
        return $this->redirectToRoute('event_list');

        //$response = new Response();
        //$response->send();
    }
}
